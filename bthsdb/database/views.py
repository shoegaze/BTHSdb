from django.http import HttpResponse
from django.shortcuts import render

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


def index(request):
	return HttpResponse("hello world")