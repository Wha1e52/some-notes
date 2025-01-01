"""
some commands:

• python manage.py sqlmigrate blog 0001         # takes the migration names and returns their PostgreSQL without executing it.



________________________________________________________________________________________________________________________
The responsibilities in the Django MTV pattern are divided as follows:

• Model – Defines the logical data structure and is the data handler between the database and
the View.
• Template – Is the presentation layer. Django uses a plain-text template system that keeps
everything that the browser renders.
• View – Communicates with the database via the Model and transfers the data to the Template
for viewing.

The framework itself acts as the Controller. It sends a request to the appropriate view, according to the Django URL configuration.

This is how Django handles HTTP requests and generates responses:

1. A web browser requests a page by its URL and the web server passes the HTTP request to Django.
2. Django runs through its configured URL patterns and stops at the first one that matches the
requested URL.
3. Django executes the view that corresponds to the matched URL pattern.
4. The view potentially uses data models to retrieve information from the database.
5. Data models provide the data definition and behaviors. They are used to query the database.
6. The view renders a template (usually HTML) to display the data and returns it with an HTTP
response.
________________________________________________________________________________________________________________________

the basic structure of the application:

• __init__.py: An empty file that tells Python to treat the blog directory as a Python module.
• admin.py: This is where you register models to include them in the Django administration
site—using this site is optional.
• apps.py: This includes the main configuration of the blog application.
• migrations: This directory will contain database migrations of the application. Migrations
allow Django to track your model changes and synchronize the database accordingly. This
directory contains an empty __init__.py file.
• models.py: This includes the data models of your application; all Django applications need to
have a models.py file but it can be left empty.
• tests.py: This is where you can add tests for your application.
• views.py: The logic of your application goes here; each view receives an HTTP request, processes
it, and returns a response.
________________________________________________________________________________________________________________________

1) the project setup:

• py -m venv venv_name
• venv_name\Scripts\activate
• pip install django
• django-admin startproject mysite
• python manage.py migrate

• python manage.py startapp blog
Activating the application:
INSTALLED_APPS = [
    ...
    'blog.apps.BlogConfig',
]

You can run the Django development server on a custom host and port or tell Django to load a specific
settings file, as follows:
• python manage.py runserver 127.0.0.1:8001 --settings=mysite.settings
When you have to deal with multiple environments that require different configurations,
you can create a different settings file for each environment.
________________________________________________________________________________________________________________________

pagination:

def post_list(request):
    post_list = Post.published.all()
    # Pagination with 3 posts per page
    paginator = Paginator(post_list, 3)
    page_number = request.GET.get('page', 1)
    posts = paginator.page(page_number)
    return render(request,
                  'blog/post/list.html',
                  {'posts': posts})

<div class="pagination">
    <span class="step-links">
    {% if page.has_previous %}
        <a href="?page={{ page.previous_page_number }}">Previous</a>
    {% endif %}
        <span class="current">
    Page {{ page.number }} of {{ page.paginator.num_pages }}.
    </span>
        {% if page.has_next %}
            <a href="?page={{ page.next_page_number }}">Next</a>
        {% endif %}
    </span>
</div>
________________________________________________________________________________________________________________________
Sending emails with Django

The following settings allow you to define the SMTP configuration to send emails with Django:
• EMAIL_HOST: The SMTP server host; the default is localhost
• EMAIL_PORT: The SMTP port; the default is 25
• EMAIL_HOST_USER: The username for the SMTP server
• EMAIL_HOST_PASSWORD: The password for the SMTP server
• EMAIL_USE_TLS: Whether to use a Transport Layer Security (TLS) secure connection
• EMAIL_USE_SSL: Whether to use an implicit TLS secure connection


from django.core.mail import send_mail
send_mail('Django mail',
... 'This e-mail was sent with Django.',
... 'your_account@gmail.com',
... ['your_account@gmail.com'],
... fail_silently=False)

The send_mail() function takes the subject, message, sender, and list of recipients as required arguments.
By setting the optional argument fail_silently=False, we are telling it to raise an exception
if the email cannot be sent. If the output you see is 1, then your email was successfully sent.
________________________________________________________________________________________________________________________
Dumping the existing data from the database into files

• python manage.py dumpdata --indent=2 --output=mysite_data.json (после dumpdata можно указать конкретный app)

If you get an encoding error when running the command, include the -Xutf8 flag as follows to activate Python UTF-8 mode:

• python -Xutf8 manage.py dumpdata --indent=2 --output=mysite_data.json
___________________________________
Loading the data into the new database:

• python manage.py loaddata mysite_data.json

By default, Django looks for files in the fixtures/ directory of each application, but you can specify
the complete path to the fixture file for the loaddata command. You can also use the FIXTURE_DIRS
setting to tell Django additional directories to look in for fixtures.

Fixtures are not only useful for setting up initial data, but also for providing sample data
for your application or data required for your tests.
________________________________________________________________________________________________________________________
Simple search lookups

from blog.models import Post
Post.objects.filter(title__search='django')
___________________________________
Searching against multiple fields

from django.contrib.postgres.search import SearchVector
from blog.models import Post

Post.objects.annotate(search=SearchVector('title', 'body'),).filter(search='django')

Full-text search is an intensive process. If you are searching for more than a few hundred
rows, you should define a functional index that matches the search vector you are
using.
________________________________________________________________________________________________________________________

• LOGIN_REDIRECT_URL: Tells Django which URL to redirect the user to after a successful login
if no next parameter is present in the request
• LOGIN_URL: The URL to redirect the user to log in (for example, views using the login_required
decorator)
• LOGOUT_URL: The URL to redirect the user to log out






















"""