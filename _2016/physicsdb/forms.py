from django import forms

class LoginForm(forms.Form):
    username = forms.CharField(label='username', max_length=30)
    password = forms.CharField(label='password', max_length=128, widget=forms.PasswordInput)
    