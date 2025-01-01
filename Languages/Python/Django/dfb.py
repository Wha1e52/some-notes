"""
When you type in a URL, such as https://djangoproject.com, the first thing that happens within our Django project is
a URL pattern (contained in urls.py) is found that matches it.
The URL pattern is linked to a single view (contained in views.py) which combines the data from the model (stored in models.py)
and the styling from a template (any file ending in .html). The view then returns a HTTP response to the user.

Django request/response cycle:
HTTP Request -> URL -> View -> Model and Template -> HTTP Response
________________________________________________________________________________________________________________________
1)
> cd onedrive\desktop\code
> mkdir news
> cd news
> python -m venv .venv
> .venv\Scripts\Activate.ps1
(.venv) > python -m pip install django~=4.0.0
(.venv) > django-admin startproject django_project .
(.venv) > python manage.py startapp accounts
________________________________________________________________________________________________________________________

2) In django_project/settings.py we’ll add the accounts app to our INSTALLED_APPS.

INSTALLED_APPS = [
    "django.contrib.admin",
    ...
    "accounts.apps.AccountsConfig", # new
]
________________________________________________________________________________________________________________________

3) Then at the bottom of settings.py use the AUTH_USER_MODEL config to tell Django to use our new custom user
model in place of the built-in User model.

AUTH_USER_MODEL = "accounts.CustomUser" # new
________________________________________________________________________________________________________________________

4) Now update accounts/models.py with a new User model called CustomUser that extends the existing AbstractUser.
We also include our a custom field for age here

• null is database-related. When a field has null=True it can store a database entry as NULL, meaning no value.
• blank is validation-related. If blank=True then a form will allow an empty value, whereas if blank=False then a value is required.
Avoid using null on string-based fields such as CharField and TextField. If a string-based field has null=True, that means it has two possible values for “no data”: NULL, and the empty string. In most cases, it’s redundant to have two possible values for “no data; the Django convention is to use the empty string, not NULL.

# accounts/models.py
from django.contrib.auth.models import AbstractUser
from django.db import models


class CustomUser(AbstractUser):
    age = models.PositiveIntegerField(null=True, blank=True)
________________________________________________________________________________________________________________________

5) Create a new file called accounts/forms.py and update it with the following code to extend the
existing UserCreationForm and UserChangeForm forms

# accounts/forms.py
from django.contrib.auth.forms import UserCreationForm, UserChangeForm
from .models import CustomUser


class CustomUserCreationForm(UserCreationForm):
    class Meta(UserCreationForm):
        model = CustomUser
        fields = UserCreationForm.Meta.fields + ("age",)


class CustomUserChangeForm(UserChangeForm):
    class Meta:
        model = CustomUser
        fields = UserChangeForm.Meta.fields
________________________________________________________________________________________________________________________

6) We need is to update our admin.py file since Admin is tightly coupled to the default User model.

We will extend the existing UserAdmin class to use our new CustomUser model. To control which fields are listed we use list_display.
But to actually edit and add new custom fields, like age, we must also add fieldsets (for fields used in editing users)
and add_fieldsets (for fields used when creating a user).

# accounts/admin.py
from django.contrib import admin
from django.contrib.auth.admin import UserAdmin
from .forms import CustomUserCreationForm, CustomUserChangeForm
from .models import CustomUser


class CustomUserAdmin(UserAdmin):
    add_form = CustomUserCreationForm
    form = CustomUserChangeForm
    model = CustomUser
    list_display = [
        "email",
        "username",
        "age",
        "is_staff",
    ]
    fieldsets = UserAdmin.fieldsets + ((None, {"fields": ("age",)}),)
    add_fieldsets = UserAdmin.add_fieldsets + ((None, {"fields": ("age",)}),)


admin.site.register(CustomUser, CustomUserAdmin)

run makemigrations and migrate for the first time to create a new database that uses the custom user model
________________________________________________________________________________________________________________________

7) Let’s create a new templates directory and within it a registration directory as that’s where
Django will look for templates related to log in and sign up

(.venv) > mkdir templates
(.venv) > mkdir templates/registration

Now we need to tell Django about this new directory by updating the configuration for "DIRS" in django_project/settings.py

# django_project/settings.py
TEMPLATES = [
    {
        ...
        "DIRS": [BASE_DIR / "templates"], # new
        ...
    }
]

If you think about what happens when you log in or log out of a site, you are immediately redirected to a subsequent page. We need to tell Django where to send users in each case
So when we make the homepage URL we’ll make sure to call it 'home'.

LOGIN_REDIRECT_URL = "home"
LOGOUT_REDIRECT_URL = "home"
________________________________________________________________________________________________________________________

8) Now we can create four new templates within our text editor

• templates/base.html
• templates/home.html
• templates/registration/login.html
• templates/registration/signup.html
________________________________________________________________________________________________________________________

9) URLs

# django_project/urls.py
from django.contrib import admin
from django.urls import path, include
from django.views.generic.base import TemplateView

urlpatterns = [
    path('admin/', admin.site.urls),
    path("accounts/", include("accounts.urls")),
    path("accounts/", include("django.contrib.auth.urls")),
    path("", TemplateView.as_view(template_name="home.html"), name="home"),  # In our django_project/urls.py file, we want to have our home.html template appear as the homepage, but we don’t want to build a dedicated pages app just yet. We can use the shortcut of importing TemplateView and setting the template_name right in our url pattern

]

# accounts/urls.py
from django.urls import path
from .views import SignUpView

urlpatterns = [
    path("signup/", SignUpView.as_view(), name="signup"),
]
________________________________________________________________________________________________________________________

10) The last step is our views.py file which will contain the logic for our sign up form

# accounts/views.py
from django.urls import reverse_lazy
from django.views.generic import CreateView
from .forms import CustomUserCreationForm


class SignUpView(CreateView):
    form_class = CustomUserCreationForm
    success_url = reverse_lazy('login')
    template_name = "registration/signup.html"
________________________________________________________________________________________________________________________

11) Currently, in accounts/forms.py under fields we’re using Meta.fields, which just displays the default settings of
username/age/password. But we can also explicitly set which fields we want displayed.
We don’t need to include the password fields because they are required! All the other fields can be configured however we choose

# accounts/forms.py
from django.contrib.auth.forms import UserCreationForm, UserChangeForm
from .models import CustomUser


class CustomUserCreationForm(UserCreationForm):
    class Meta(UserCreationForm):
        model = CustomUser
        fields = (
            "username",
            "email",
            "age",
        )


class CustomUserChangeForm(UserChangeForm):
    class Meta:
        model = CustomUser
        fields = (
            "username",
            "email",
            "age",
        )
________________________________________________________________________________________________________________________

12)













There is, however, another approach which is to instead create a single project-level templates directory
and place all templates within there.

TEMPLATES = [
    {
        ...
        "DIRS": [BASE_DIR / "templates"],
        ...
    },
]

STATICFILES_DIRS = [BASE_DIR / "static"]

All test methods must start with the phrase test* so that Django knows to test them!
"""