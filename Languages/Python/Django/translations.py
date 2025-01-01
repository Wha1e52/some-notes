"""
You will need the gettext toolkit to be able to create, update, and compile message files.
https://docs.djangoproject.com/en/4.1/topics/i18n/translation/#gettext-on-windows


LANGUAGES = [
    ('en', 'English'),
    ('es', 'Spanish'),
]

Add 'django.middleware.locale.LocaleMiddleware' to the MIDDLEWARE setting. Make sure that this
middleware comes after SessionMiddleware because LocaleMiddleware needs to use session data. It
also has to be placed before CommonMiddleware because the latter needs an active language to resolve
the requested URL.

MIDDLEWARE = [
    ...
    'django.contrib.sessions.middleware.SessionMiddleware',
    'django.middleware.locale.LocaleMiddleware',
    'django.middleware.common.CommonMiddleware',
     ...
]

The locale directory is the place where message files for your application will reside. Edit the settings.
py file again and add the following setting to it:

LOCALE_PATHS = [
    BASE_DIR / 'locale',
]

Create the following directory structure inside the main project directory, next to the manage.py file:
locale/
en/
es/
________________________________________________________________________________________________________________________

from django.utils.translation import gettext as _

month = _('April')
day = '14'
output = _('Today is %(month)s %(day)s') % {'month': month, 'day': day}

Plural forms in translations:
For plural forms, you can use ngettext() and ngettext_lazy().

output = ngettext('there is %(count)d product', 'there are %(count)d products', count) % {'count': count}
________________________________________________________________________________________________________________________
Internationalization management commands

Django includes the following management commands to manage translations:

    • makemessages: This runs over the source tree to find all the strings marked for translation and
creates or updates the .po message files in the locale directory. A single .po file is created
for each language.

    • compilemessages: This compiles the existing .po message files to .mo files, which are used to
retrieve translations.

django-admin makemessages --all
django-admin compilemessages
________________________________________________________________________________________________________________________
from django.utils.translation import gettext_lazy as _

class Order(models.Model):
    first_name = models.CharField(_('first name'),
    max_length=50)
    last_name = models.CharField(_('last name'),
    max_length=50)
_______________________________________________________

class CartAddProductForm(forms.Form):
    quantity = forms.TypedChoiceField(choices=PRODUCT_QUANTITY_CHOICES,
                                      coerce=int,
                                      label=_('Quantity'))
________________________________________________________________________________________________________________________
Translating templates

Django offers the {% trans %} and {% blocktrans %} template tags to translate the strings in templates.
In order to use the translation template tags, you have to add {% load i18n %} to the top of
your template to load them.
_______________________________________________________
The {% trans %} template tag

The {% trans %} template tag allows you to mark a literal for translation. Internally, Django executes
gettext() on the given text. This is how to mark a string for translation in a template:

{% trans "Text to be translated" %}

{% trans "Hello!" as greeting %}
<h1>{{ greeting }}</h1>
_______________________________________________________

The {% blocktrans %} template tag

The {% blocktrans %} template tag allows you to mark content that includes literals and variable
content using placeholders. The following example shows you how to use the {% blocktrans %} tag,
including a name variable in the content for translation:

{% blocktrans %}Hello {{ name }}!{% endblocktrans %}

{% blocktrans with name=user.name|capfirst %}
Hello {{ name }}!
{% endblocktrans %}

Use the {% blocktrans %} tag instead of {% trans %} when you need to include variable
content in your translation string.
________________________________________________________________________________________________________________________
Using the Rosetta translation interface

pip install django-rosetta

INSTALLED_APPS = [
# ...
'rosetta',
]

urlpatterns = [
...
path('rosetta/', include('rosetta.urls')),
...
]

If you want other users to be able to edit translations, open http://127.0.0.1:8000/admin/
auth/group/add/ in your browser and create a new group named translators. Then, access
http://127.0.0.1:8000/admin/auth/user/ to edit the users to whom you want to grant permissions
so that they can edit translations. When editing a user, under the Permissions section, add the
translators group to the Chosen Groups for each user. Rosetta is only available to superusers or
users who belong to the translators group.
You can read Rosetta’s documentation at https://django-rosetta.readthedocs.io/.

"""
