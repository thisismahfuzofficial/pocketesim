<x-main>
    @section('title',$page->title)
    @section('description',$page->meta_description)
    @section('keywords',$page->meta_keywords)
    
    @push('css')
        <style>
            /* Base styles for the .page-body class */
            .page-body {
                font-family: 'Helvetica Neue', Arial, sans-serif;
                /* Font similar to the example */
                padding: 20px;
                /* Padding inside the element */
                margin: 10px auto;
                /* Centered with auto margins */
                max-width: 1200px;
                /* Maximum width of the element */
                border: 1px solid #ddd;
                /* Light grey border */
                border-radius: 8px;
                /* Rounded corners */
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                /* Subtle shadow */
            }

            /* Example styling for headings inside .page-body */
            .page-body h1,
            .page-body h2,
            .page-body h3 {
                color: #2c3e50;
                /* Dark slate blue */
                margin-top: 0;
                /* No top margin */
                font-weight: bold;
            }

            /* Example styling for paragraphs inside .page-body */
            .page-body p {
                color: #34495e;
                /* Slate grey */
                line-height: 1.6;
                /* Line height for better readability */
                margin-bottom: 20px;
                /* Space below paragraphs */
            }

            /* Example styling for links inside .page-body */
            .page-body a {
                color: #3498db;
                /* Light blue */
                text-decoration: none;
                /* No underline */
            }

            .page-body a:hover {
                text-decoration: underline;
                /* Underline on hover */
            }

            /* Example styling for buttons inside .page-body */
            .page-body button {
                background-color: #3498db;
                /* Light blue background */
                color: #fff;
                /* White text */
                border: none;
                /* No border */
                padding: 10px 20px;
                /* Padding */
                border-radius: 4px;
                /* Rounded corners */
                cursor: pointer;
                /* Pointer cursor */
                font-size: 16px;
                /* Font size */
            }

            .page-body button:hover {
                background-color: #2980b9;
                /* Darker blue on hover */
            }

            /* Example styling for images inside .page-body */
            .page-body img {
                max-width: 100%;
                /* Responsive images */
                height: auto;
                /* Maintain aspect ratio */
                display: block;
                /* Block level */
                margin: 0 auto;
                /* Centered */
            }

            /* Example styling for lists inside .page-body */
            .page-body ul,
            .page-body ol {
                color: #34495e;
                /* Slate grey */
                margin-bottom: 20px;
                /* Space below lists */
                padding-left: 20px;
                /* Indentation */
            }

            .page-body li {
                margin-bottom: 10px;
                /* Space below list items */
            }

            /* Example styling for cards inside .page-body */
            .page-body .card {
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 20px;
                margin-bottom: 20px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            /* Example styling for icons inside .page-body */
            .page-body .icon {
                font-size: 48px;
                color: #3498db;
                /* Light blue */
                margin-bottom: 10px;
            }

            /* Example styling for section headers inside .page-body */
            .page-body .section-header {
                font-size: 24px;
                font-weight: bold;
                margin-bottom: 20px;
                color: #2c3e50;
                /* Dark slate blue */
            }
        </style>
    @endpush
    <div class="account__header">
        <div class="breadcrumbs">
            <a href="{{ url('/') }}"><img src="../img/icons/home.svg" alt="home"></a>
            <img class="breadcrumbs__arrow breadcrumbs__account-info" src="../img/icons/right-arrow-breadcrumb.svg"
                alt="arrow">
            <a href="{{ route('page', $page) }}" class="breadcrumbs__account-info">{{ $page->title }}</a>
        </div>
        <div class="account__header__content">
            <div class="account__header__content__texts">
                <h1>{{ $page->title }}</h1>
            </div>
        </div>
    </div>
    <div>
        <div class="partner-with-us-content">
            <div class="page-body">
                {!! $page->body !!}

            </div>
        </div>
    </div>
</x-main>
