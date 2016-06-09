from django.conf.urls import url

from . import views

urlpatterns = [
    url(r'^example$', views.example_view, name='example'),
	url(r'^$',        views.index,        name='index'),
]