from django.contrib.auth.decorators import login_required
from django.conf.urls import url

from . import views


app_name = 'database'
urlpatterns = [
    #url(r'^example$',    views.example_view,       name='example'),
	url(r'^$',          views.IndexView.as_view(), name='index'),
	url(r'^dashboard$', views.dashboard,           name='dashboard'),
	url(r'^manage$',    views.manage_equipment,    name='manage_equipment'),
	url(r'^login$',     views.login,               name='login'),
	url(r'^take_out$',  views.take_out,            name='take_out'),
	url(r'^give_back$', views.give_back,           name='give_back'),
	url(r'^all$',       login_required(views.DisplayAllView.as_view()), name='display_all'),
]