"""
#urls.py
urlpatterns = [
    path('', index, name='home'),
]

в redirect можем указать как саму view, так и url-адрес, либо по имени маршрута определенном в urls.py
redirect(index), redirect('/'), redirect('home'). Как правило, используют имена маршрутов.

по умолчанию код перенаправления 302, если указать параметр permanent=True то код перенаправления будет 301
redirect('/', permanent=True)

301 - страница перемещена на другой постоянный адрес
302 - страница временно перемещена на другой адрес

либо можно использовать их вместо redirect:
HttpResponsePermanentRedirect - для редиректа с кодом 301
HttpResponseRedirect - для редиректа с кодом 302
________________________________________________________________________________________________________________________
from django.shortcuts import render, redirect


def index(request):
    return render(request, 'index.html')

def redirect_to_home(request):
    return redirect('home')
"""