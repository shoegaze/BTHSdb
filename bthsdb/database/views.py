from django.shortcuts import render, redirect, get_object_or_404
from django.views import generic
from django.views.generic.base import TemplateView
from django.views.generic import ListView

from django.http import HttpResponse, HttpResponseRedirect
from django.core.urlresolvers import reverse

from django.contrib import auth
from django.contrib.auth import authenticate, login, logout
from django.contrib.auth.decorators import login_required

from django.utils import timezone

from django.contrib.auth.models import User
from .models import Equipment
from .forms import LoginForm

# Create your views here.
def example_view(request):
	html = r"""
			<html>
				<head>
					<title>example view for django</title>
				</head>
				<body style="background-color:#212121;">
					<div style="background-color:#00FF00;width:5%;margin:0 auto;">
						Hello world
					</div>
				</body>
			</html>
			"""
	
	return HttpResponse(html)



class IndexView(TemplateView):
    template_name = 'database/index.html'

    def get_context_data(self, **kwargs):
        context = super(IndexView, self).get_context_data(**kwargs)
        context['login_form'] = LoginForm
        return context

	
def login(request):
	error_message = ''
	login_form = LoginForm(request.POST)
	
	if request.method == 'POST':
		if login_form.is_valid():
			username = login_form.cleaned_data['username']
			password = login_form.cleaned_data['password']
			user = authenticate(username=username, password=password)
			
			if user is not None:
				if user.is_active:
					auth.login(request, user)
					return redirect('database:dashboard')
				else:
					error_message = 'user disabled!'
			else:
				error_message = 'wrong login!'
	
	return redirect('database:index')
	

@login_required
def dashboard(request):
	return render(request, 'database/dashboard.html', {'user':request.user})
	

class DisplayAllView(ListView):
	template_name = 'database/display_all.html'
	model = Equipment
	
"""
take out equipment if id is valid
set equipment.taken_out_time = now -> this will 
	make the equipment visible in the user's page
"""
@login_required
def take_out(request):
	if request.method == 'POST' and request.POST['equipment_id']:
		equipment_id = request.POST['equipment_id']
		equipment = get_object_or_404(Equipment, pk=equipment_id)
		
		equipment.take_out_time = timezone.now()
		equipment.take_out_user = User.objects.get(id=request.user.id)
		equipment.save()
	
	return redirect('database:display_all')


@login_required
def give_back(request):
	if request.method == 'POST' and request.POST['equipment_id']:
		equipment_id = request.POST['equipment_id']
		equipment = get_object_or_404(Equipment, pk=equipment_id)
		
		equipment.take_out_time = None
		equipment.take_out_user = None
		equipment.save()
	
	return redirect('database:manage_equipment')


def manage_equipment(request):
	taken_out = Equipment.objects.filter(take_out_user=User.objects.get(id=request.user.id))
	return render(request, 'database/manage_equipment.html', {'taken_out':taken_out})