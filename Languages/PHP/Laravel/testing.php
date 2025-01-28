<?php

/*
Написание простого теста маршрута POST
// tests/Feature/AssignmentTest.php
public function test_post_creates_new_assignment() {
    $this->post('/assignments', [
        'title' => 'My great assignment',
    ]);

    $this->assertDatabaseHas('assignments', [
        'title' => 'My great assignment',
    ]);
}

Написание простого теста маршрута GET
// AssignmentTest.php
public function test_list_page_shows_all_assignments() {
    $assignment = Assignment::create([
        'title' => 'My great assignment',
    ]);

    $this->get('/assignments')
        ->assertSee('My great assignment');
}

// Тестирование взаимодействия с базой данных с помощью простых тестов приложения
public function test_active_page_shows_active_and_not_inactive_contacts()
{
    $activeContact = Contact::factory()->create();
    $inactiveContact = Contact::factory()->inactive()->create();
    $this->get('active-contacts')
        ->assertSee($activeContact->name)
        ->assertDontSee($inactiveContact->name);
}

// Использование assertDatabaseHas() для проверки определенных записей в базе данных
public function test_contact_creation_works()
{
    $this->post('contacts', [
        'email' => 'jim@bo.com'
    ]);
    $this->assertDatabaseHas('contacts', [
        'email' => 'jim@bo.com'
    ]);
}

// Тестирование аксессоров, мутаторов и областей действия
public function test_full_name_accessor_works()
{
    $contact = Contact::factory()->make([
        'first_name' => 'Alphonse',
        'last_name' => 'Cumberbund'
    ]);
    $this->assertEquals('Alphonse Cumberbund', $contact->fullName);
}
public function test_vip_scope_filters_out_non_vips()
{
    $vip = Contact::factory()->vip()->create();
    $nonVip = Contact::factory()->create();
    $vips = Contact::vips()->get();
    $this->assertTrue($vips->contains('id', $vip->id));
    $this->assertFalse($vips->contains('id', $nonVip->id));
}




















*/