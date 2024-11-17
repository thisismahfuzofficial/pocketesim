<x-main>
    <div class="account__header">
        <div class="breadcrumbs">
            <a href="{{ route('home') }}"></a>
            <img class="breadcrumbs__arrow breadcrumbs__account-info" src="../img/icons/right-arrow-breadcrumb.svg"
                alt="arrow">
            <a href="{{ route('show.about.us') }}" class="breadcrumbs__account-info">About Us</a>
        </div>
        <div class="account__header__content">
            <div class="account__header__content__texts">
                <h1>Rreth nesh</h1>
            </div>
        </div>
    </div>
    <div class="static-pages-content about-us">
        <div class="about-us-text">
            <img src="../img/mock/about-img.jpg" alt="about-img">
            <div class="about-us-text-content">
                <div class="about-us-text-top">
                    <h2>Mirë se vini në merr5G.</h2>
                    <p>
                        merr5G është pasaporta juaj për lidhshmëri të pandërprerë në të gjithë botën.
                        Ne nuk jemi vetëm një ofrues eSIM për udhëtime; ne jemi shoqëruesi juaj i besueshëm për të qëndruar të lidhur kudo që t'ju çojnë aventurat tuaja.
                    </p>
                </div>
                <div class="about-us-top-infos">
                    <div class="about-us-top-info-item">
                        <div class="info-item-title">
                            <i class="icon-pckt-target"></i>
                            <h3>Our Mission</h3>
                        </div>
                        <div class="info-item-text">
                            At merr5G, our mission is to redefine the way you stay connected while traveling. We
                            understand that seamless communication is essential for modern travelers, and our innovative
                            eSIM solutions are designed to make your journey worry-free and connected.
                        </div>
                    </div>
                    <div class="about-us-top-info-item">
                        <div class="info-item-title">
                            <i class="icon-pckt-quotes"></i>
                            <h3>Our Story</h3>
                        </div>
                        <div class="info-item-text">
                            Our journey began with mobile wifi solutions. In 2021, a team of travel enthusiasts and tech
                            experts came togethr to PWT Teknoloji A.S started as a mobile wifi solutions tech company.
                            Later, in 2023, it started working on e-SIM solutions.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="info-blocks">
            <div class="info-item">
                <i class="info-item-icon icon-pckt-globe-simple"></i>
                <div class="info-item-desc">
                    <h3>
                        Anytime, Anywhere Connectivity
                    </h3>
                    <p>
                        Say goodbye to the hassle of searching for local SIM cards or dealing with expensive roaming
                        charges. With merr5G, you have the freedom to connect anytime, anywhere. Our eSIMs work
                        seamlessly in over 200 countries, ensuring you're always in touch with your loved ones or
                        colleagues.
                    </p>
                </div>
            </div>
            <div class="info-item">
                <i class="info-item-icon icon-pckt-sim-card"></i>
                <div class="info-item-desc">
                    <h3>
                        Hassle-Free Activation
                    </h3>
                    <p>
                        We understand that your time is precious, especially when you're on the move. That's why we've
                        made the activation process of our eSIMs as simple as possible. No more queuing at airports or
                        filling out tedious forms—just activate your eSIM with a few taps on your phone.
                    </p>
                </div>
            </div>
            <div class="info-item">
                <i class="info-item-icon icon-pckt-airplane"></i>
                <div class="info-item-desc">
                    <h3>
                        Dedicated to Travelers
                    </h3>
                    <p>
                        Unlike traditional telecom providers, we specialize in catering to the unique needs of
                        travelers. Our customer support team is available 24/7 to assist you with any inquiries or
                        issues, ensuring that your travel experience is smooth and stress-free.
                    </p>
                </div>
            </div>
        </div>


    </div>

    <x-faq :faqs="$faqs"></x-faq>
    <x-services></x-services>
</x-main>
