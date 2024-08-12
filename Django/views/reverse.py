"""
reverse - выстраивает url-адрес по имени маршрута в urls.py

#urls.py
app_name = 'myapp'

urlpatterns = [
    path('', index, name='index'),
    path('post/<int:pk>/', post_detail, name='post_detail'),
]
________________________________________________________________________________________________________________________
from django.urls import reverse
from django.shortcuts import redirect

reverse('post_detail', kwargs={'pk': 1})
||
reverse('post_detail', args=[1])
вернет:
# '/post/1/'


def my_view(request):
    url = reverse('myapp:index')
    return redirect(url)
"""
