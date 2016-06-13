from django.db import models
from django.contrib.auth.models import User
from django.conf import settings
from django.utils import timezone

"""
# Create your models here.
class Equipment(models.Model):
	name = models.CharField(max_length=100)
	shelf = models.ForeignKey('Shelf')

	
class Shelf(models.Model):
	label = models.CharField(max_length=100)
	room_number = models.CharField(max_length=6)
	

class Teacher():

"""

class Equipment(models.Model):
	class Meta:
		ordering = ['register_date']
		app_label = 'database'

	name = models.CharField(max_length=100)
	subject = models.CharField(max_length=64)
	shelf_label = models.CharField(max_length=16)
	room_number = models.CharField(max_length=6)
	
	register_date = models.DateTimeField('date registered', default=timezone.now)
	take_out_time = models.DateTimeField('time taken out', default=None, blank=True, null=True)
	take_out_user = models.ForeignKey(settings.AUTH_USER_MODEL, on_delete=models.SET_NULL, default=None, blank=True, null=True)
	
	
	def __str__(self):
		return str(self.name)
	
	
	#if take out time is not null, equipment is not taken out
	def was_taken_out(self):
		return self.take_out_time is not None
    
	was_taken_out.admin_order_field = 'take_out_time'
	was_taken_out.boolean = True
	was_taken_out.description = 'equipment taken out?'
    
	def get_user(self):
		return self.take_out_user.get_username()
    
	get_user.admin_order_field = 'take_out_time'
	get_user.description = 'get current user.'