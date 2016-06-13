from django.contrib import admin

from .models import Equipment


class EquipmentAdmin(admin.ModelAdmin):
	fields = ['name', 'subject', 'shelf_label', 'room_number', 'take_out_user', 'take_out_time']
	list_display = ('name', 'subject', 'shelf_label', 'room_number', 'take_out_user', 'take_out_time')
	list_filter = ['take_out_time']


admin.site.register(Equipment, EquipmentAdmin)