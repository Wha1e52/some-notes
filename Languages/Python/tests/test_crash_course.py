# The name of a test file is important; it must start with "test_".
# Test functions need to start with the word "test_", followed by an underscore.
# The name of a function should make it clear which behavior of a func we’re testing
# When a parameter in a test function matches the name of a function with the @pytest.fixture decorator,
#   the fixture will be run automatically and the return value will be passed to the test function.
"""In projects with many tests, or in situations where it takes many lines to build a resource
that’s used in multiple tests, fixtures can drastically improve your test code"""

import pytest
def get_formatted_city_name(city, country, population=None):
    if population:
        neat_str = f'{city.title()}, {country.title()} – population {population}'
    else:
        neat_str = f'{city}, {country}'.title()
    return neat_str


class AnonymousSurvey:
    """Collect anonymous answers to a survey question."""

    def __init__(self, question):
        """Store a question, and prepare to store responses."""
        self.question = question
        self.responses = []

    def show_question(self):
        """Show the survey question."""
        print(self.question)

    def store_response(self, new_response):
        """Store a single response to the survey."""
        self.responses.append(new_response)

    def show_results(self):
        """Show all the responses that have been given."""
        print("Survey results:")
        for response in self.responses:
            print(f"- {response}")


class Employee:
    def __init__(self, first, last, salary):
        self.first = first
        self.last = last
        self.salary = salary

    def give_raise(self, amount=5000):
        self.salary += amount



def test_city_country():
    assert get_formatted_city_name('vologda', 'russia') == 'Vologda, Russia'


def test_city_country_population():
    assert get_formatted_city_name('vologda', 'russia', 300000) == 'Vologda, Russia – population 300000'


def test_raise_city_country():
    with pytest.raises(TypeError):
        get_formatted_city_name('vologda')


@pytest.fixture
def language_survey():
    """A survey that will be available to all test functions."""
    question = "What language did you first learn to speak?"
    language_survey = AnonymousSurvey(question)
    return language_survey


def test_store_single_response(language_survey):
    """Test that a single response is stored properly."""
    language_survey.store_response('Xyu')
    assert 'Xyu' in language_survey.responses


def test_store_three_responses(language_survey):
    """Test that three individual responses are stored properly."""
    responses = ['English', 'Spanish', 'Mandarin']
    for response in responses:
        language_survey.store_response(response)
    for response in responses:
        assert response in language_survey.responses


@pytest.fixture
def empl():
    return Employee('Alex', 'Garcia', 22000)


def test_give_default_raise(empl):
    empl.give_raise()
    assert empl.salary == 27000


def test_give_custom_raise(empl):
    empl.give_raise(10000)
    assert empl.salary == 32000
