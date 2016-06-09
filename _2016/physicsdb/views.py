from django.shortcuts import get_object_or_404, render
from django.http import HttpResponseRedirect
from django.views import generic

from django.contrib.auth.decorators import login_required
from django.contrib.auth.models import User
from django.contrib.auth import authenticate, logout

from django.utils import timezone

from .models import Equipment
from .forms import LoginForm
from django.contrib.auth.decorators import login_required


def index(request):
    form = LoginForm()
    return render(request, 'physicsdb/index.html', {'form':form})


def login(request):
    if request.method == 'POST':
        form = LoginForm(request.POST)
        
        if form.is_valid():
            uname = form.cleaned_data['username']
            passw = form.cleaned_data['password']
            
            user = authenticate(username=uname, password=passw)
                
            if user is not None:
                if user.is_active:
                    return render(request, 'physicsdb/userpage.html')
                
                else:
                    return render(request, 'physicsdb/index.html', {'form':form,'error_message':'disabled user!'})
            
            else:
                return render(request, 'physicsdb/index.html', {'form':form,'error_message':'invalid login details'})
    
    return render(request, 'physicsdb/index.html', {'form':form,'error_message':'incomplete fields'})

#display all equipment in main page
@login_required
def userpage(request):
    taken = Equipment.objects.filter(take_out_user=User.objects.get(id=request.user.id))
    return render(request, 'physicsdb/userpage.html', {'taken_out':taken,'user':request.user})
    
@login_required
def take_out(request):
    equip_id = ''
    
    if request.method == 'POST' and request.POST['equipment_id']:
        equip_id = request.POST['equipment_id']
        
    try:
        equipment = Equipment.objects.get(pk=equip_id)
        
    except(KeyError, Equipment.DoesNotExist):
        equipment = Equipment.objects.all().order_by('register_date')
        return render(request, 'physicsdb/overview.html', {
                'equipment' : equipment,
                'error_message' : 'you didn`t select a valid equipment to take',
            })
    else:
        if equipment.take_out_user is not None:
            return render(request, 'physicsdb/userpage.html', {'error_message':'equipment already taken out'})
        
        equipment.take_out_time = timezone.now()
        equipment.take_out_user = User.objects.get(id=request.user.id)
        equipment.save()
        
        return userpage(request)

@login_required
def give_back(request):
    equip_id = ''
    
    if request.method == 'POST' and request.POST['equipment_id']:
        equip_id = request.POST['equipment_id']
        
    try:
        equipment = Equipment.objects.get(pk=equip_id)
        
    except(KeyError, Equipment.DoesNotExist):
        equipment = Equipment.objects.all().order_by('register_date')
        return render(request, 'physicsdb/overview.html', {
                'equipment' : equipment,
                'error_message' : 'you didn`t select a valid equipment to take',
            })
    else:
        if equipment.take_out_user != User.objects.get(id=request.user.id):
            return render(request, 'physicsdb/userpage.html', {'error_message':'equipment not yours'})
        
        equipment.take_out_time = None
        equipment.take_out_user = None
        equipment.save()
    
        return userpage(request)

@login_required
def overview(request):
    #get all available equipment from db
    #  select all from equipment order by __
    equipment = Equipment.objects.all().order_by('register_date')
    return render(request, 'physicsdb/overview.html', {'equipment':equipment})
    
    