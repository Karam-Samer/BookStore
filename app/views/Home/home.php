<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookStore</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('CSS/plugins/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/plugins/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/style.css') }}">


    <!-- JS -->
    <script src="{{ asset('JS/plugins/jquery.js') }}"></script>
    <script src="{{ asset('JS/plugins/bootstrap.js') }}"></script>

</head>

<body>
    <x-Navbar />

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="carousel-dot active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" class="carousel-dot" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" class="carousel-dot" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 d-flex align-items-center">
                            <div class="item">
                                <h5>SEARCH BOOK EASILY</h5>
                                <h2 class="h1 mb-3">ISBN Search Feature</h2>
                                <p class="mb-4">Search books using ISBN numbers or Author names and save your time</p>
                                <button class="btn mainButton">Read More</button>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center">
                            <div class="item">
                                <img src="{{ asset('images/slide_1.png') }}" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 d-flex align-items-center">
                            <div class="item">
                                <h5>LARGEST CATALOG</h5>
                                <h2 class="h1 mb-3">Over 12 Million Books</h2>
                                <p class="mb-4">Start your Learning journey by browsing Millions of books from our library</p>
                                <button class="btn mainButton">Read More</button>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center">
                            <div class="item">
                                <img src="{{ asset('images/slide_2.png') }}" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 d-flex align-items-center">
                            <div class="item">
                                <h5>EMBED PDF FEATURE</h5>
                                <h2 class="h1 mb-3">Read PDF Books Online</h2>
                                <p class="mb-4">Let your customers read books online without leaving your website</p>
                                <button class="btn mainButton">Read More</button>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center">
                            <div class="item">
                                <img src="{{ asset('images/slide_3.png') }}" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>