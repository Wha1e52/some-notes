"""
You use CharField when you want to store a small amount of text, such as a name, a title, or a city. When we define a CharField attribute, we have to tell Django how much space it should reserve in the database. Here we give it a max_length of 200 characters, which should be enough to hold most topic names.
The date_added attribute is a DateTimeField, a piece of data that will record a date and time 2. We pass the argument auto_now_add=True, which tells Django to automatically set this attribute to the current date and time whenever the user creates a new topic.
It’s a best practice to add str() methods to all of your models to improve their readability.

class Entry(models.Model):
    '''Something specific learned about a topic.'''
    topic = models.ForeignKey(Topic, on_delete=models.CASCADE)     # The on_delete=models.CASCADE argument tells Django that when a topic is deleted, all the entries associated with that topic should be deleted as well. This is known as a cascading delete.
    text = models.TextField()
    date_added = models.DateTimeField(auto_now_add=True)

    class Meta:
        verbose_name_plural = 'entries'                             # The Meta class holds extra information for managing a model; here, it lets us set a special attribute telling Django to use Entries when it needs to refer to more than one entry. Without this, Django would refer to multiple entries as Entrys.

    def __str__(self):
        '''Return a simple string representing the entry.'''
        return f"{self.text[:50]}..."

    def get_absolute_url(self):                                     # для того чтобы перенаправлять на нужную страницу
        return reverse("<name url_tamplate>", kwargs={"pk": self.pk})

________________________________________________________________________________________________________________________
from django.db import models
from django.utils import timezone
from django.contrib.auth.models import User

class PublishedManager(models.Manager):                         # кастомный менеджер
    def get_queryset(self):
        return super().get_queryset().filter(status=Post.Status.PUBLISHED)

class Post(models.Model):

    class Status(models.TextChoices):
        DRAFT = 'DF', 'Draft'
        PUBLISHED = 'PB', 'Published'

    title = models.CharField(max_length=250)
    slug = models.SlugField(max_length=250)
    author = models.ForeignKey(User,                            # This field defines a many-to-one relationship, meaning that each post is written by a user, and a user can write any number of posts
                               on_delete=models.CASCADE,
                               related_name='blog_posts')       # to specify the name of the reverse relationship, from User to Post (user.blog_posts)
    body = models.TextField()
    publish = models.DateTimeField(default=timezone.now)
    created = models.DateTimeField(auto_now_add=True)           # auto_now_add добавляется при создании объекта
    updated = models.DateTimeField(auto_now=True)               # auto_now добавляется при изменении объекта
    status = models.CharField(max_length=2,
                              choices=Status.choices,
                              default=Status.DRAFT)
    objects = models.Manager()                                  # если не укажем, он перестанет существовать т.к добавили свой менеджер
    published = PublishedManager()                              # явно указываем кастомный менеджер

    class Meta:
        ordering = ['-publish']                                 # добавляем сортировку
        indexes = [
            models.Index(fields=['-publish']),
        ]

    def __str__(self):
        return self.title

• python manage.py makemigrations blog
• python manage.py migrate
________________________________________________________________________________________________________________________

ForeignKey - many2one

у одного owner может быть множество Course:

class Course(models.Model):
    owner = models.ForeignKey(User,
                              related_name='courses_created',
                              on_delete=models.CASCADE)
________________________________________________________________________________________________________________________
Using model inheritance

Django supports model inheritance. It works in a similar way to standard class inheritance in Python.
Django offers the following three options to use model inheritance:

    • Abstract models: Useful when you want to put some common information into several models.
    • Multi-table model inheritance: Applicable when each model in the hierarchy is considered
        a complete model by itself.
    • Proxy models: Useful when you need to change the behavior of a model, for example, by
        including additional methods, changing the default manager, or using different meta options.

________________________________________________________________________________________________________________________
ManyToMany

class Course(models.Model):
    ...
    students = models.ManyToManyField(User, related_name='courses_joined', blank=True)

















"""


