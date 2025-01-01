"""
• python manage.py createsuperuser
________________________________________________________________________________________________________________________
admin.py

from django.contrib import admin, messages
from .models import Post


class SomeFilter(admin.SimpleListFilter):
    title = 'some title'
    parameter_name = 'some_parameter'

    def lookups(self, request, model_admin):

        return (
            ('some_value', 'Some value'),
            ('some_value2', 'Some value2'),
        )

    def queryset(self, request, queryset):
        if self.value() == 'some_value':  # возвращает значение из parameter_name
            return queryset.filter(some_field__contains=self.value())


@admin.register(Post)
class PostAdmin(admin.ModelAdmin):
    fields = ('title', 'slug', 'author', 'body')               # отображение полей уже в самой записи в админке
    exclude = ('body', )                               # исключить поля уже в самой записи в админке
    readonly_fields = ('author',)                                # поля только для чтения уже в самой записи в админке
    prepopulated_fields = {'slug': ('title',)}                 # автоматически заполняемые поля уже в самой записи в админке
    filter_horizontal/vertical = ('tags', )                             # для другого отображения поля ManyToMany уже в самой записи в админке

    list_display = ['title', 'slug', 'author', 'publish', 'status', 'some_function']             # allows to set the fields of your model that you want to display on the administration object list page.
    list_display_links = ['title', 'slug']                          # кликабельные ссылки
    list_editable = ['status', 'publish']                           # позволяет редактировать в списке админки. не может быть и кликабельным(list_display_links)
    list_per_page = 10                                              # пагинация для отображения в админке
    actions = ['some_action']                                       # действия с выбранными объектами
    list_filter = [SomeFilter, 'status', 'created', 'publish', 'author']        # фильтрация по полям
    search_fields = ['title', 'body']                               # поиск по тексту, в указанных полях. Можно прописывать люкапы __
    save_on_top = True                                              # добавить кнопку "Сохранить" и наверху страницы
    raw_id_fields = ['author']
    date_hierarchy = 'publish'
    ordering = ['-status', 'publish']                       # можно указывать и в обратном порядке через -

    # чтобы создать новое поле для отображения в админке
    @admin.display(description='Number of symbols', ordering='body')  # можно сортировать, но нужно указать другое поле, какая-то ебала.
    def some_function(self, obj):
        return len(obj.body)


    @admin.action(description='Publish selected posts')
    def some_action(self, request, queryset):
        count = queryset.update(is_published=Post.Status.PUBLISHED)
        self.message_user(request, f'{count} posts were successfully published')

    @admin.action2(description='Draft selected posts')
    def some_action(self, request, queryset):
        count = queryset.update(is_published=Post.Status.DRAFT)
        self.message_user(request, f'{count} posts were drafted', messages.WARNING)
________________________________________________________________________________________________________________________
urls.py

admin.site.site_header = "Django Admin"         # default: "Django Administration"
admin.site.index_title = "Welcome to Django"    # default: "Site administration"
________________________________________________________________________________________________________________________
models.py

SomeClassModel:

    # для нормального отображения в админке и не только указываем verbose_name в каждом поле
    name = models.CharField(max_length=255, verbose_name="MyField")
    ...

    class Meta:
        verbose_name = "MyClass"            # для отображения имени модели в админке
        verbose_name_plural = "MyClasses"
________________________________________________________________________________________________________________________
apps.py

SomeClassConfig:
    verbose_name = "MyClass"

"""