@extends('front.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@endsection

@section('content')
    <section class="page-banner services-page-banner">
        <h1 class="h1 banner-quote to-left">We're all about you</h1>
    </section>
    <section class="page-section">
        <h1 class="h1 section-title">Services</h1>
        <p class="strong-lead">
            I am some intro to the services section. I introduce the service section, what it is exactly, entice to look.
        </p>
        <div class="services-container">
            <div class="service-writeup">
                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M4 10v7h3v-7H4zm6 0v7h3v-7h-3zM2 22h19v-3H2v3zm14-12v7h3v-7h-3zm-4.5-9L2 6v2h19V6l-9.5-5z"/>
                </svg>
                <p class="body-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque debitis dolorum earum eveniet magni nisi quis saepe veritatis. Ab asperiores corporis deleniti itaque iure modi placeat rerum sint ut velit! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto dolorum facere incidunt ipsum libero maxime nobis officiis optio rerum! Aspernatur autem facere facilis itaque labore natus nihil, placeat repudiandae vitae.</p>
            </div>
            <div class="service-writeup">
                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M4 10v7h3v-7H4zm6 0v7h3v-7h-3zM2 22h19v-3H2v3zm14-12v7h3v-7h-3zm-4.5-9L2 6v2h19V6l-9.5-5z"/>
                </svg>
                <p class="body-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci architecto aspernatur dolorem hic illum. Facilis ipsa itaque minima necessitatibus reprehenderit? Adipisci culpa cumque eos error ipsam maiores officia, repellat tenetur. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus architecto corporis deserunt dolorem doloremque eligendi excepturi itaque magnam nam nesciunt obcaecati, officia optio praesentium quaerat quia quis quo soluta unde.</p>
            </div>
            <div class="service-writeup">
                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M4 10v7h3v-7H4zm6 0v7h3v-7h-3zM2 22h19v-3H2v3zm14-12v7h3v-7h-3zm-4.5-9L2 6v2h19V6l-9.5-5z"/>
                </svg>
                <p class="body-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum excepturi harum pariatur quasi quia ratione reprehenderit suscipit, tempore. A cumque dicta doloremque dolores earum eius eveniet nostrum odit perferendis voluptas! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque aut, deleniti dolore doloremque est fuga ipsam nostrum officia praesentium reiciendis reprehenderit similique sit voluptatum. Error eveniet fuga nesciunt quo sed.</p>
            </div>
            <div class="service-writeup">
                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M4 10v7h3v-7H4zm6 0v7h3v-7h-3zM2 22h19v-3H2v3zm14-12v7h3v-7h-3zm-4.5-9L2 6v2h19V6l-9.5-5z"/>
                </svg>
                <p class="body-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam asperiores fuga hic ipsum maxime necessitatibus obcaecati pariatur perferendis quaerat reiciendis, repellat repellendus saepe sed ullam velit? Facere fugit mollitia quos? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut debitis dicta dignissimos eos fugit labore magni minima minus nesciunt nostrum odio perferendis quibusdam quidem quisquam, velit. Consequuntur debitis magnam voluptate.</p>
            </div>
        </div>
        <div class="map-container">
            <img src="/images/assets/world_map.jpg" alt="Map of Buffalo trading countries">
        </div>
    </section>
    @include('front.partials.footer')
@endsection