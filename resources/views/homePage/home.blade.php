@extends('layouts.main')

@section('title', $title)

@section('content')
    <main class="home-page">
        <section class="home-banner">
            <div class="home-content">
                <h1 class="left">WEB PRO</h1>
                <div class="right">
                    <h2>Tun Usaha</h2>
                    <p>Web Design</p>
                    <p>This is my website to study 954348
                        <br>I wish I will be able to make this could be better
                    </p>
                </div>
                <div class="image">
                    <img src="{{ asset('images/content1.png') }}" alt="">
                </div>
            </div>
        </section>

        <section class="grid grid-1">
            <figure>
                <img src="{{ asset('images/sich.png') }}" alt="">
            </figure>
            <figure>
                <img src="{{ asset('images/3.png') }}" alt="" class="autoRotate">
            </figure>
            <h2 class="autoShow">Introduce</h2>
        </section>

        <section class="grid grid-2">
            <div class="autoShow">
                <figure>
                    <img src="{{ asset('images/6.png') }}" alt="">
                </figure>
                <p>
                    When exploring the intricate world of art, I find myself captivated by Greek sculpture, which embodies
                    timeless beauty and craftsmanship.<br> The elegance and detail in each piece tell stories of ancient
                    cultures, reflecting their values and beliefs. Similarly, my passion for data science allows me to delve
                    into complex patterns and insights, transforming raw information into meaningful narratives. This unique
                    blend of interests drives my creativity and analytical thinking, inspiring me to discover connections
                    between the past and the present.
                </p>
            </div>

            <div class="autoShow">
                Cyber security is a crucial field in today's digital landscape, where threats to information integrity and
                privacy are ever-present. With the rapid evolution of technology, the importance of protecting sensitive
                data has never been more significant. My fascination with cyber security stems from its dynamic nature, as
                it requires constant vigilance and adaptation to emerging threats. From understanding vulnerabilities in
                systems to implementing robust security measures, I am drawn to the challenge of safeguarding information in
                an increasingly interconnected world. This field not only allows me to think critically and analytically but
                also empowers me to contribute to a safer digital environment for all.
            </div>

            <div class="autoShow">
                <figure>
                    <img src="{{ asset('images/Content2.png') }}" alt="">
                </figure>
                <p>
                    In a world where challenges are constantly reshaping our paths, we must embrace the spirit of innovation
                    and resilience. Just as an unknown printer took a collection of type and transformed it into something
                    new, we too can take the chaos around us and turn it into opportunities for growth. Every setback is a
                    stepping stone, and with determination, we can leap into new territories, remaining true to ourselves
                    while evolving along the way. Remember, the journey may be unpredictable, but it’s in those moments of
                    change that we discover our true potential.
                </p>
            </div>

            <div class="autoBLur">
                <figure>
                    <img src="{{ asset('images/candy.png') }}" alt="Candy" />
                </figure>
            </div>
        </section>

        <section class="grid grid-3">
            <div class="autoBLur">TUNUSAHA</div>
            <div class="autoBLur">DESIGNER</div>
            <div class="autoBLur">DEVELOPER</div>
        </section>
    </main>
@endsection
