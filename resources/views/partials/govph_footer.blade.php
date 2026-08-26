<footer class="govph-footer" aria-label="Government information footer">
    <div class="container-fluid px-4 px-lg-5">
        <div class="row g-4 g-xl-5 align-items-start">
            <div class="col-12 col-md-6 col-xl-3">
                <div class="govph-brand">
                    <img src="{{ asset('images/logo/Footer image.png') }}" alt="Republic of the Philippines seal">
                    <div>
                        <h2>Republic of the<br>Philippines</h2>
                        <p>All content is in the public domain unless otherwise stated.</p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-2">
                <h2>About GOVPH</h2>
                <p>Learn more about the Philippine government, its structure, how government works and the people behind it.</p>
                <ul>
                    <li><a href="https://www.gov.ph/" target="_blank" rel="noopener">GOV.PH</a></li>
                    <li><a href="https://data.gov.ph/" target="_blank" rel="noopener">Open Data Portal</a></li>
                    <li><a href="https://www.officialgazette.gov.ph/" target="_blank" rel="noopener">Official Gazette</a></li>
                </ul>
            </div>

            <div class="col-12 col-md-6 col-xl-2">
                <h2>Government Links</h2>
                <ul>
                    <li><a href="https://president.gov.ph/" target="_blank" rel="noopener">Office of the President</a></li>
                    <li><a href="https://ovp.gov.ph/" target="_blank" rel="noopener">Office of the Vice President</a></li>
                    <li><a href="https://www.senate.gov.ph/" target="_blank" rel="noopener">Senate of the Philippines</a></li>
                    <li><a href="https://www.congress.gov.ph/" target="_blank" rel="noopener">House of Representatives</a></li>
                    <li><a href="http://sc.judiciary.gov.ph/" target="_blank" rel="noopener">Supreme Court</a></li>
                    <li><a href="https://ca.judiciary.gov.ph/" target="_blank" rel="noopener">Court of Appeals</a></li>
                    <li><a href="https://sb.judiciary.gov.ph/" target="_blank" rel="noopener">Sandiganbayan</a></li>
                    <li><a href="https://dswd.gov.ph/" target="_blank" rel="noopener">DSWD</a></li>
                </ul>
            </div>

            <div class="col-12 col-md-6 col-xl-2">
                <h2>Contact Us</h2>
                <p>3RD Floor, Matapat Building Department Of Social Welfare And Development - Central Office IBP Road, Constitution Hills, Batasan Complex, Quezon City</p>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <h2>Email:</h2>
                <p><a href="mailto:soctech@dswd.gov.ph">soctech@dswd.gov.ph</a></p>
                <h2 class="govph-phone-heading">Telephone Number:</h2>
                <ul class="govph-phone-list">
                    <li><i class="bi bi-telephone-fill me-1" aria-hidden="true"></i>02-8951-7124</li>
                    <li><i class="bi bi-telephone-fill me-1" aria-hidden="true"></i>02-8951-2802</li>
                    <li><i class="bi bi-telephone-fill me-1" aria-hidden="true"></i>02-8931-8144</li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<style>
    .govph-footer {
        border-top: 1px solid #d9d9d9;
        background: #fff;
        color: #7890a8;
        font-family: "Trebuchet MS", Arial, sans-serif;
        padding: 30px 0 34px;
    }

    .govph-footer h2 {
        color: #7890a8;
        font-size: 1.2rem;
        font-weight: 400;
        line-height: 1.1;
        margin: 0 0 14px;
    }

    .govph-footer p,
    .govph-footer li {
        font-size: .7rem;
        line-height: 1.5;
    }

    .govph-footer p {
        margin: 0 0 14px;
    }

    .govph-footer ul {
        margin: 0;
        padding-left: 22px;
    }

    .govph-footer li {
        padding-left: 2px;
        margin-bottom: 2px;
    }

    .govph-footer a {
        color: #06f;
        text-decoration: none;
    }

    .govph-footer a:hover,
    .govph-footer a:focus-visible {
        text-decoration: underline;
    }

    .govph-brand {
        position: relative;
        min-height: 260px;
    }

    .govph-brand img {
        position: absolute;
        z-index: 0;
        top: -12px;
        left: -14px;
        width: 270px;
        max-width: none;
        height: auto;
        object-fit: contain;
        opacity: .42;
    }

    .govph-brand > div {
        position: relative;
        z-index: 1;
        padding: 0 0 0 142px;
    }

    .govph-brand h2 {
        margin-top: 0;
    }

    .govph-phone-heading {
        margin-top: 26px !important;
    }

    .govph-phone-list {
        list-style: none;
        padding-left: 0 !important;
    }

    @media (max-width: 767.98px) {
        .govph-footer {
            padding-top: 24px;
        }

        .govph-brand {
            min-height: 220px;
        }

        .govph-brand img {
            top: -6px;
            left: -8px;
            width: 220px;
        }

        .govph-brand > div {
            padding-left: 112px;
        }

        .govph-footer h2 {
            font-size: 1.2rem;
        }
    }
</style>
