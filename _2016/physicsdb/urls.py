from django.conf.urls import url

from . import views


app_name = 'physicsdb'
urlpatterns = [
    url(r'^$', views.index, name='index'),
    url(r'^db/$', views.overview, name='overview'),
    url(r'^db/user/$', views.userpage, name='userview'),
    url(r'^take_out/$', views.take_out, name='takeout'),
    url(r'^give_back/$', views.give_back, name='giveback'),
    
    #user authentication urls
    url(r'^db/login/$', views.login, name='login'),
    #url(r'^', include('django.contrib.auth.urls')),
]
