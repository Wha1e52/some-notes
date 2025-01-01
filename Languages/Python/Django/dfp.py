"""
1)
• create a Dockerfile with custom image instructions

# Pull base image
FROM python:3.10.4-slim-bullseye
# Set environment variables
ENV PIP_DISABLE_PIP_VERSION_CHECK 1
ENV PYTHONDONTWRITEBYTECODE 1
ENV PYTHONUNBUFFERED 1
# Set work directory
WORKDIR /code
# Install dependencies
COPY ./requirements.txt .
RUN pip install -r requirements.txt
# Copy project
COPY . .

2)
• add a .dockerignore file

.venv
.git
.gitignore

3)
• build the image

docker build .

4)
• create a docker-compose.yml file

version: "3.9"
services:
    web:
        build: .
        command: python /code/manage.py runserver 0.0.0.0:8000
        volumes:
            - .:/code
        ports:
            - 8000:8000

5)
• spin up the container(s)

docker-compose up -d
________________________________________________________________________________________________________________________
Since we’re working within Docker now as opposed to locally we must preface traditional
commands with docker-compose exec [service] where we specify the name of the service

docker-compose exec web python manage.py createsuperuser
________________________________________________________________________________________________________________________

устанавливаем адаптер для работы с postgresql
pip install psycopg2-binary


switching over to PostgreSQL:

# django_project/settings.py
DATABASES = {
    "default": {
        "ENGINE": "django.db.backends.postgresql",
        "NAME": "postgres",
        "USER": "postgres",
        "PASSWORD": "postgres",
        "HOST": "db",
        "PORT": 5432,
    }
}
________________________________________________________________________________________________________________________

custom user model

1. Create a CustomUser model
2. Update django_project/settings.py
3. Customize UserCreationForm and UserChangeForm
4. Add the custom user model to admin.py

___________________________________________

# accounts/models.py

from django.contrib.auth.models import AbstractUser
from django.db import models

class CustomUser(AbstractUser):
    pass
___________________________________________

# django_project/settings.py

INSTALLED_APPS = [
    ...
    # Local
    "accounts.apps.AccountsConfig",
]

We also want to add a AUTH_USER_MODEL config at the bottom of the file which will cause our project to use CustomUser instead of the default User model.

AUTH_USER_MODEL = "accounts.CustomUser"

docker-compose exec web python manage.py makemigrations accounts
docker-compose exec web python manage.py migrate
___________________________________________

Custom User Forms

from django.contrib.auth.forms import UserCreationForm, UserChangeForm
from django.contrib.auth import get_user_model


class CustomUserCreationForm(UserCreationForm):
    class Meta:
        model = get_user_model()
        fields = (
            "email",
            "username",
        )


class CustomUserChangeForm(UserChangeForm):
    class Meta:
        model = get_user_model()
        fields = (
            "email",
            "username",
        )
___________________________________________

Custom User Admin

from django.contrib import admin
from django.contrib.auth import get_user_model
from django.contrib.auth.admin import UserAdmin
from .forms import CustomUserCreationForm, CustomUserChangeForm

CustomUser = get_user_model()


class CustomUserAdmin(UserAdmin):
    add_form = CustomUserCreationForm
    form = CustomUserChangeForm
    model = CustomUser
    list_display = [
        "email",
        "username",
        "is_superuser",
    ]


admin.site.register(CustomUser, CustomUserAdmin)
___________________________________________

we’ll install the WhiteNoise package since Django does not support serving static files in
production itself

python -m pip install whitenoise

WhiteNoise must be added to django_project/settings.py in the following locations:
• whitenoise above django.contrib.staticfiles in INSTALLED_APPS
• WhiteNoiseMiddleware above CommonMiddleware
• STATICFILES_STORAGE configuration pointing to WhiteNoise

INSTALLED_APPS = [
    ...
    "whitenoise.runserver_nostatic",
    "django.contrib.staticfiles",
]

MIDDLEWARE = [
    "django.middleware.security.SecurityMiddleware",
    "django.contrib.sessions.middleware.SessionMiddleware",
    "whitenoise.middleware.WhiteNoiseMiddleware",
    ...
]

STATIC_URL = "/static/"
STATICFILES_DIRS = [BASE_DIR / "static"] # new
STATIC_ROOT = BASE_DIR / "staticfiles" # new
STATICFILES_STORAGE = "whitenoise.storage.CompressedManifestStaticFilesStorage"
___________________________________________
collectstatic - command collects the static files from all applications of the project into the path defined with the STATIC_ROOT setting.

# django_project/settings.py

STATIC_URL = 'static/'
# STATIC_URL - префикс URL-адреса для статических файлов

STATICFILES_DIRS = [BASE_DIR / "static"]
# STATICFILES DIRS - список дополнительных (нестандартных) путей к статическим файлам, используемых для сбора и для режима отладки.

STATIC_ROOT = BASE_DIR / "staticfiles"
# STATIC_ROOT - путь к общей статической папке, формируемой при запуске команды collectstatic (для сбора всей статики в единый каталог при размещении сайта на реальном веб-сервере);

STATICFILES_STORAGE = "django.contrib.staticfiles.storage.StaticFilesStorage"

python manage.py collectstatic








"""
