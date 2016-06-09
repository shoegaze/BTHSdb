from django.contrib import admin

from .models import Equipment


class EquipmentAdmin(admin.ModelAdmin):
    fields = ['equipment_name', 'equipment_id', 'take_out_time']
    list_display = ('equipment_id', 'equipment_name', 'was_taken_out')
    list_filter = ['take_out_time']


admin.site.register(Equipment, EquipmentAdmin)