from django.db import models
from django.conf import settings
from django.utils import timezone


class Equipment(models.Model):
    class Meta:
        ordering = ['register_date']
        app_label = 'physicsdb'
    
    #add equipment types below as '(NAME),' .
    EQUIPMENT_TYPES = (
    
    )
    
    #pk datatype can be changed here 
    equipment_id = models.CharField(max_length=32, primary_key=True)
    equipment_name = models.CharField(max_length=128)
    register_date = models.DateTimeField('date registered', default=timezone.now)
    #if take_out_time is null, it's not taken out
    take_out_time = models.DateTimeField('time taken out', default=None, blank=True, null=True)
    take_out_user = models.ForeignKey(settings.AUTH_USER_MODEL, on_delete=models.SET_NULL, default=None, blank=True, null=True)
    
    def __str__(self):
        return str(self.equipment_name)
        
    def was_taken_out(self):
        return self.take_out_time is not None
    
    was_taken_out.admin_order_field = 'take_out_time'
    was_taken_out.boolean = True
    was_taken_out.description = 'equipment taken out?'
    
    def get_user(self):
        return take_out_user.get_username()
    
    get_user.admin_order_field = 'take_out_time'
    get_user.description = 'get current user.'
