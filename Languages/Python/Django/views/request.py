"""
def index(request):
    return render(request, 'learning_logs/index.html')

https://remanga.org/manga?page=1&types=1

request.GET - будет содержать пары ключ значения из url после ? в виде словаря {'page': ['1'], 'types': ['1']}
request.POST - будет содержать данные из форм

"""