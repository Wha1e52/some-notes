'''

1) работа с виртуальной средой
- python -m venv .name_venv           # создаем виртуальную среду через терминал
- Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser             # если работаем в powershell, чтобы включить выполнение сторонних скриптов
- venv\scripts\activate               # активируем ее (in powershell, you might need to capitalize activate.)
- deactivate                          # to stop using a virtual environment, enter deactivate

1.5) устанавливаем django:
- python -m pip install django
________________________________________________________________________________________________________________________

2) создание проекта django
- django-admin startproject name_project .                # создает проект с именем (name_project)

• manage.py - is used to execute various Django commands such as running the local web server or creating a new app.
• settings.py - controls how django interacts with your system and manages your project.
• urls.py - tells django which pages to build in response to browser requests.
• wsgi.py - stands for Web Server Gateway Interface which helps Django serve our eventual web pages
• asgi.py - allows for an optional Asynchronous Server Gateway Interface to be run
________________________________________________________________________________________________________________________

3) создание базы данных
- python manage.py migrate             # при первом запуске создаст базу данных
________________________________________________________________________________________________________________________

4) запуск сервера
- python manage.py runserver          # запуск сервера

if you receive the error message “that port is already in use,” tell django to use a different port by entering
python manage.py runserver 8001 and then cycling through higher numbers until you find an open port.
________________________________________________________________________________________________________________________

5) создание ифраструктуры

- python manage.py startapp <app name>

• admin.py is a configuration file for the built-in Django Admin app
• apps.py is a configuration file for the app itself
• migrations/ keeps track of any changes to our models.py file so it stays in sync with our database
• models.py is where we define our database models which Django automatically translates into database tables
• tests.py is for app-specific tests
• views.py is where we handle the request/response logic for our web app

Even though our new app exists within the Django project, Django doesn’t “know” about it until we explicitly add it to the django_project/settings.py file.
________________________________________________________________________________________________________________________

6) activating apps

installed_apps = [
    # my apps.
    'name_project',
    # default django apps.
    'django.contrib.admin',
    ...
]

it’s important to place your own apps before the default apps, in case you need to override any behavior of the default apps with your own custom behavior.

or

INSTALLED_APPS = [
    "django.contrib.admin",
    ...
    "name_project.apps.PagesConfig",
]

________________________________________________________________________________________________________________________

7) create models and next, we need to tell django to modify the database so it can store information related to the model topic
- python manage.py makemigrations learning_logs

the command makemigrations tells django to figure out how to modify the database so it can store the data associated with any new models we’ve defined.

as a best practice, adopt the habit of always including the name of an app when executing the makemigrations command!

now we’ll apply this migration and have django modify the database for us

- python manage.py migrate

whenever we want to modify the data that learning log manages, we’ll follow these three steps:
-modify models.py,
-call makemigrations on learning_logs,
-tell django to migrate the project.

________________________________________________________________________________________________________________________

making pages

making web pages with django consists of three stages: defining urls, writing views, and writing templates. you can do these in any order

10.1) we need to include the urls for our app, so add the following:

from django.contrib import admin
from django.urls import path, include
urlpatterns = [
    path('admin/', admin.site.urls),
    path('', include('learning_logs.urls')),
]
________________________________________________________________________________________________________________________
now we need to make a second urls.py file in the learning_logs folder. create a new python file, save it as
urls.py in learning_logs, and enter this code into it:

from django.urls import path
from . import views

app_name = 'learning_logs'
urlpatterns = [
    # home page
    path('', views.index, name='index'),       # when using Class-Based Views, you always add as_view() at the end of the view name. <path('', views.index.as_view(), name='index'),>
]
________________________________________________________________________________________________________________________
10.2) writing a view

def index(request):
    """the home page for learning log."""
    return render(request, 'learning_logs/index.html')

or

from django.views.generic import TemplateView

class Index(TemplateView):
    template_name = "learning_logs/index.html"
____________________________________________

def topics(request):
    topics = Topic.objects.filter(owner=request.user).order_by('-date_added')
    context = {'topics': topics}
    return render(request, 'learning_logs/topics.html', context)

or

class HomePageView(ListView):               # ListView automatically returns to us a context variable called <model>_list, where <model> is our model name, that we can loop over via the built-in for template tag.
    model = Post
    template_name = "home.html"

________________________________________________________________________________________________________________________
10.3) writing a template

inside the learning_logs folder(app), make a new folder called templates. inside the templates folder,
make another folder called learning_logs(the same name as app). inside the inner learning_logs folder,
make a new file called index.html.

django will take the requested url, and that url will match the pattern ''; then django will call the function views.index(), which will render the page using the template contained in index.html.
________________________________________________________________________________________________________________________

11) working with templates

{% url 'learning_logs:index' %} - ссылка на url с именем index в urls.py в папке learning_logs
если нужно, можно указать атрибуты:
{% url 'learning_logs:topic' topic.id %}
________________________________________________________________________________________________________________________
12) forms

-создаем файл forms.py

from django import forms
from .models import topic


class topicform(forms.modelform):
    class meta:
        model = topic
        fields = ['text']
        labels = {'text': ''}
        widgets = {'text': forms.textarea(attrs={'cols': 80})}

- пишем view

def new_topic(request):
    """add a new topic."""
    if request.method != 'post':
        # no data submitted; create a blank form.
        form = topicform()
    else:
        # post data submitted; process data.
        form = topicform(data=request.post)
        if form.is_valid():
            form.save()
            return redirect('learning_logs:topics')
    # display a blank or invalid form.
    context = {'form': form}
    return render(request, 'learning_logs/new_topic.html', context)

- пишем template

{% extends "learning_logs/base.html" %}
{% block content %}
    <p>add a new topic:</p>
    <form action="{% url 'learning_logs:new_topic' %}" method='post'>
        {% csrf_token %}
        {{ form.as_div }}
        <button name="submit">add topic</button>
    </form>
{% endblock content %}
________________________________________________________________________________________________________________________
13) the login page
we’ll use the default login view django provides, so the url pattern for this app looks a little different:
app_name = 'accounts'
urlpatterns = [
# include default auth urls.
path('', include('django.contrib.auth.urls')),
]

EVERY FORM IN DJANGO NEEDS TO INCLUDE THE {% csrf_token %}

14) the login template
ll_project/accounts/templates/registration/login.html
    {% if form.errors %}
        <p>your username and password didn't match. please try again.</p>
    {% endif %}
    <form action="{% url 'accounts:login' %}" method='post'>
        {% csrf_token %}
        {{ form.as_div }}
        <button name="submit">log in</button>
    </form>

15) the login_redirect_url settting
once a user logs in successfully, django needs to know where to send that user. we control this in the settings file
# my settings.
LOGIN_REDIRECT_URL = 'learning_logs:index'

16) Logout
the request has to be sent as a POST request

{% if user.is_authenticated %}
    <hr/>
    <form action="{% url 'accounts:logout' %}" method='post'>
        {% csrf_token %}
        <button name='submit'>Log out</button>
    </form>
{% endif %}

# My settings.
LOGIN_REDIRECT_URL = 'learning_logs:index'

________________________________________________________________________________________________________________________

17) Restricting Access

from django.contrib.auth.decorators import login_required

@login_required
def some_func(request):

Add the following at the end of settings.py:

# My settings.
LOGIN_REDIRECT_URL = 'learning_logs:index'
LOGOUT_REDIRECT_URL = 'learning_logs:index'
LOGIN_URL = 'accounts:login'

________________________________________________________________________________________________________________________
18) Connecting Data to Certain Users

from django.contrib.auth.models import User
class Topic(models.Model):
    """A topic the user is learning about."""
    Text = models.CharField(max_length=200)
    date_added = models.DateTimeField(auto_now_add=True)
    owner = models.ForeignKey(User, on_delete=models.CASCADE)

'''
