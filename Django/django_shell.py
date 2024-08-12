"""
пакет django-extensions # расширяет возможности shell
# python manage.py shell_plus --print-sql
________________________________________________________________________________________________________________________
# https://docs.djangoproject.com/en/5.0/topics/db/queries/
# https://docs.djangoproject.com/en/5.0/ref/models/querysets/#field-lookups

Django Shell

- python manage.py shell       # launches a Python interpreter that you can use to explore the data stored in your project’s database.

>> from learning_logs.models import Topic
>> Topic.objects.all()                                  # to get all instances of the model Topic; the list that’s returned is called a queryset.
<QuerySet [<Topic: Chess>, <Topic: Rock Climbing>]>

- We can loop over a queryset just as we’d loop over a list.
Here’s how you can see the ID that’s been assigned to each topic object:
>> topics = Topic.objects.all()
>> for topic in topics:
... print(topic.id, topic)
...
1 Chess
2 Rock Climbing

- If you know the ID of a particular object, you can use the method Topic.objects.get() to retrieve that object
and examine any attribute the object has. Let’s look at the text and date_added values for Chess:

>> t = Topic.objects.get(id=1)
>> t.text
'Chess'
>> t.date_added
datetime.datetime(2022, 5, 20, 3, 33, 36, 928759, tzinfo=datetime.timezone.utc)

- To get data through a foreign key relationship, you use the lowercase name of the related model
followed by an underscore and the word set:
>> t.entry_set.all()
<QuerySet [<Entry: The opening is the first part of the game, roughly...>, <Entry: In the opening phase of the game, it's important t...>]>

The shell is really useful for making sure your code retrieves the data you want it to. If your code works as you expect it to in the shell, it should also work properly in the files within your project.
Each time you modify your models, you’ll need to restart the shell to see the effects of those changes. To exit a shell session, press CTRL-D; on Windows, press CTRL-Z and then press ENTER.
________________________________________________________________________________________________________________________
________________________________________________________________________________________________________________________
________________________________________________________________________________________________________________________
When QuerySets are evaluated

QuerySets are only evaluated in the following cases:

• The first time you iterate over them
• When you slice them, for instance, Post.objects.all()[:3]
• When you pickle or cache them
• When you call repr() or len() on them
• When you explicitly call list() on them
• When you test them in a statement, such as bool(), or, and, or if
________________________________________________________________________________________________________________________
from django.contrib.auth.models import User
from blog.models import Post

user = User.objects.get(username='admin')

The get() method allows you to retrieve a single object from the database. Note that this method
expects a result that matches the query. If no results are returned by the database, this method will
raise a DoesNotExist exception, and if the database returns more than one result, it will raise a
MultipleObjectsReturned exception.
___________________________________________

post = Post(title='Another post',
            slug='another-post',
            body='Post body.',
            author=user)
post.save()
||
Post.objects.create(title='One more post',
                    slug='one-more-post',
                    body='Post body.',
                    author=user)
___________________________________________
Updating objects

post = Post.objects.get(id=1)
post.title = 'New title'
post.save()
____
update применяется к списку объектов:

posts = Post.objects.update(is_published=True) # обновляет is_published для всех постов
posts = Post.objects.filter(pk__in=[1, 3, 5]).update(is_published=True)

___________________________________________
Deleting objects

If you want to delete an object, you can do it from the object instance using the delete() method:

post = Post.objects.get(id=1)
post.delete()
___________________________________________
To retrieve all objects from a table, we use the all() method on the default objects manager, like this:

all_posts = Post.objects.all()
___________________________________________
Using the filter() method

Post.objects.filter(publish__year=2022, author__username='admin')
This equates to building the same QuerySet chaining multiple filters:
Post.objects.filter(publish__year=2022).filter(author__username='admin')
___________________________________________
Using exclude()

You can exclude certain results from your QuerySet using the exclude() method of the manager. For
example, you can retrieve all posts published in 2022 whose titles don’t start with Why:

Post.objects.filter(publish__year=2022).exclude(title__startswith='Why')
___________________________________________
Using order_by()

You can order results by different fields using the order_by() method of the manager. For example,
you can retrieve all objects ordered by their title, as follows:

Post.objects.order_by('title')

Ascending order is implied. You can indicate descending order with a negative sign prefix, like this:

Post.objects.order_by('-title')

________________________________________________________________________________________________________________________
class Course(models.Model):
    ...
    owner = models.ForeignKey(User, related_name='courses_created', on_delete=models.CASCADE)

course = Course.objects.get(pk=1)

если у объекта присутствует ForeignKey и мы к нему обратимся (сourse.owner) будет произведен дополнительный sql запрос
для получения owner, он ведь находится в другой таблице.

________________________________________________________________________________________________________________________
ManyToMany

class Course(models.Model):
    ...
    students = models.ManyToManyField(User, related_name='courses_joined', blank=True)


user1 = User.objects.get(pk=1)
user2 = User.objects.get(pk=2)
user3 = User.objects.get(pk=3)

course = Course.objects.get(pk=1)

course.students.set([user1, user2])
course.students.add(user3)
course.students.remove(user1)
________________________________________________________________________________________________________________________
Q() objects

| - логическое ИЛИ
& - логическое И
~ - логическое НЕ

from django.db.models import Q

Post.objects.filter(publish__year=2022, author__username='admin') = publish__year=2022 AND author__username='admin'

Post.objects.filter(~Q(publish__year=2022) | Q(author__username='admin')) = NOT publish__year=2022 OR author__username='admin'
________________________________________________________________________________________________________________________
F() objects
# можно работать со значениями полей

from django.db.models import F, Value

Post.objects.filter(publish__year=F('author__year'))
Post.objects.update(publish=F('publish') + datetime.timedelta(days=1))

course = Course.objects.get(pk=1)
course.some_field = F('some_field') + 1

# annotate добавляет новое поле для выборки
# When you need to represent the value of an integer, boolean, or
string within an expression, you can wrap that value within a Value().

Post.objects.annotate(some_field=Value(True))
Post.objects.annotate(some_field=Value(2*10))
Post.objects.annotate(some_field=F('another_field') * 3)
________________________________________________________________________________________________________________________
Post.objects.first()
Post.objects.last()

#для поля datetime
Post.objects.earliest('publish')
Post.objects.latest('publish')

post = Post.objects.get(pk=1)

post.get_previous_by_имя поля с датой и временем()
post.get_next_by_имя поля с датой и временем()

course = Course.objects.get(pk=1)
course.students.exists()
course.students.count()
Post.objects.filter(is_published=True).count()
________________________________________________________________________________________________________________________
агрегатные функции

from django.db.models import Count, Sum, Avg, Min, Max
# aggregate возвращает словарь с результатами агрегации

Post.objects.aggregate(Min('id'))                                  #  {'id__min': 1}
Post.objects.aggregate(some_name=Min('id'), some_name2=Max('id'))  #  {'some_name': 1, 'some_name2': 100}
Post.objects.aggregate(some_name=Max('id') - Min('id')) # нужно явно указывать имя агрегируемого поля

Post.objects.values('some_field', 'some_field2') # вернет список словарей только с указанными полями
Post.objects.values('some_field', 'some_field2__some_field') # будет INNER_JOIN c some_field2
________________________________________________________________________________________________________________________
группировка

Post.objects.values('some_field').annotate(some_name=Count('some_field'))
________________________________________________________________________________________________________________________
Оптимизация SQL запросов

если есть дублирующие запросы, нужно их оптимизировать

select_related(key) – «жадная» загрузка связанных данных по внешнему ключу key, который имеет тип ForeignKey;
prefetch_related(key) – «жадная» загрузка связанных данных по внешнему ключу key, который имеет тип ManyToManyField.

как я понял происходит обычный JOIN
Course.objects.select_related('students')
"""