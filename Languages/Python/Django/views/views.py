"""
TemplateView - to display a template file on our homepage.

class HomePageView(TemplateView):
    template_name = "home.html"
________________________________________________________________________________________________________________________
todo ListView

ListView - to list the contents of our database model.

class PostListView(ListView):
    queryset = Post.published.all()
    context_object_name = 'posts'
    paginate_by = 3
    template_name = 'blog/post/list.html'

• We use queryset to use a custom QuerySet instead of retrieving all objects.
Instead of defining a queryset attribute, we could have specified model = Post and Django would have built the
generic Post.objects.all() QuerySet for us.

• We use the context variable posts for the query results.
The default variable is "object_list" if you don’t specify any context_object_name.

• We define the pagination of results with paginate_by, returning three objects per page.

• We use a custom template to render the page with template_name.
We can explicitly tell the view which template to use by adding a template_name attribute to the view,
but in the absence of an explicit template Django will infer one from the object’s name.
In this case, the inferred template will be "books/publisher_list.html" –
the “books” part comes from the name of the app that defines the model, while the “publisher” bit is
the lowercased version of the model’s name.

ListView automatically returns to us a context variable called <model>_list / object_list,
where <model> is our model name, that we can loop over via the built-in 'for' template tag.
_______________________________________________________________
Dynamic filtering (передаем параметры в url)

# urls.py
from django.urls import path
from books.views import PublisherBookListView

urlpatterns = [
    path("books/<publisher>/", PublisherBookListView.as_view()),
]

# views.py
from django.shortcuts import get_object_or_404
from django.views.generic import ListView
from books.models import Book, Publisher


class PublisherBookListView(ListView):
    template_name = "books/books_by_publisher.html"

    def get_queryset(self):
        self.publisher = get_object_or_404(Publisher, name=self.kwargs["publisher"])
        return Book.objects.filter(publisher=self.publisher)

    def get_context_data(self, **kwargs):
        # Call the base implementation first to get a context
        context = super().get_context_data(**kwargs)
        # Add in the publisher
        context["publisher"] = self.publisher
        return context

________________________________________________________________________________________________________________________
todo DetailView

DetailView - provide a context object we can use in our template via a primary key or a slug passed to it

class BlogDetailView(DetailView):
    model = Post
    template_name = "post_detail.html"

By default, DetailView will provide a context object we can use in our template called either
'object' or the lowercased name of our model, which would be post.

DetailView expects either a primary key or a slug passed to it as the identifier.
If you find using post or object confusing it is possible to explicitly name the context object in
our view using context_object_name (context_object_name = 'my_favorite_publishers')

Often you need to present some extra information beyond that provided by the generic view.

    def get_context_data(self, **kwargs):
        # Call the base implementation first to get a context
        context = super().get_context_data(**kwargs)
        # Add in a QuerySet of all the books
        context["book_list"] = Book.objects.all()
        return context

Generally, get_context_data will merge the context data of all parent classes with those of the current class.
To preserve this behavior in your own classes where you want to alter the context,
you should be sure to call get_context_data on the super class.

The model argument, which specifies the database model that the view will operate upon, is
available on all the generic views that operate on a single object or a collection of objects.
However, the model argument is not the only way to specify the objects that the view will operate upon –
you can also specify the list of objects using the queryset argument

Specifying model = Publisher is shorthand for saying queryset = Publisher.objects.all().
_________________________________________________________
get_object is the method that retrieves the object – so we override it and wrap the call:

# urls.py
from django.urls import path
from books.views import AuthorDetailView

urlpatterns = [
    # ...
    path("authors/<int:pk>/", AuthorDetailView.as_view(), name="author-detail"),
]

# views.py
from django.utils import timezone
from django.views.generic import DetailView
from books.models import Author


class AuthorDetailView(DetailView):
    queryset = Author.objects.all()

    def get_object(self):
        obj = super().get_object()
        # Record the last accessed date
        obj.last_accessed = timezone.now()
        obj.save()
        return obj

________________________________________________________________________________________________________________________

CreateView -

class BlogCreateView(CreateView):
    model = Post
    template_name = "post_new.html"
    fields = ["title", "author", "body"]  # если нужны все поля, можно указать '__all__'

нужно обязательно указать ссылку для перенаправления:
    success_url = reverse_lazy('home'), либо через get_absolute_url в модели
________________________________________________________________________________________________________________________

UpdateView -

class BlogUpdateView(UpdateView):
    model = Post
    template_name = "post_edit.html"
    fields = ["title", "body"]

нужно обязательно указать ссылку для перенаправления:
    success_url = reverse_lazy('home'), либо через get_absolute_url в модели
UpdateView expects either a primary key or a slug passed to it as the identifier.
________________________________________________________________________________________________________________________

DeleteView -

class BlogDeleteView(DeleteView):
    model = Post
    template_name = "post_delete.html"
    success_url = reverse_lazy("home")

By default, DeleteView will provide a context object we can use in our template called either 'object' or the lowercased
name of our model, which would be post.
нужно обязательно указать ссылку для перенаправления:
    success_url = reverse_lazy('home')
DeleteView expects either a primary key or a slug passed to it as the identifier.


"""