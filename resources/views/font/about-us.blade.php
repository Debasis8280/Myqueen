@extends('font.layouts.main')

@section('content')
    <main class="main">
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ route('users.index') }}"><i class="d-icon-home"></i></a></li>
                    <li>About Us</li>
                </ul>
            </div>
        </nav>

        <img src="{{ asset('asset/image/font/about-us-.jpg') }}" alt="" class="img-fluid" style="width:100%" />
        <div class="pt-10 mt-10 page-content">

            <!-- End About Section-->

            <section class="pb-10 customer-section appear-animate">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="mb-4 col-md-5">
                            <figure>
                                <img src="{{ asset('asset/image/font/brand.png') }}" alt="Happy Customer" width="580"
                                    height="507" class="banner-radius" style="background-color: #BDD0DE;" />
                            </figure>
                        </div>
                        <div class="mb-4 col-md-7">
                            <h5 class="section-subtitle lh-2 ls-md font-weight-normal">About us</h5>

                            <p class="section-desc text-grey">
                                MYQUEEN is from a high-end skin care brand in Singapore, advocating the skin care concept of
                                "scientific skin repair". The company has a research and development center in the UK and a
                                skin laboratory in Singapore. Relying on the combination of unique plant formulas and
                                advanced technology, it creates a royal level Skin care boutique. We are well aware of the
                                traditions of Eastern culture and our passion for young skin. We use exclusive formulas and
                                cutting-edge technology to create innovative skin care products
                            </p>
                            <p><b>Brand concept:
                                </b>scientifically repair the skin</p>
                            <p><b>Brand mission:</b>
                                Let the myth of the British Queen Elizabeth's immortality happen to women all over the world
                            </p>
                            <p><b>Brand policy:</b> Through continuous in-depth exploration of the skin and comprehensive
                                in-depth research results of many natural ingredients, the modern skin beauty concept is
                                integrated into the product, and medical expertise and advanced technology are used to solve
                                skin problems and bring moist and healthy skin.
                            </p>
                            <p><b>Brand vision: </b>To develop unique formulas for oriental skin, we believe that only
                                scientific skin care can have healthy skin.</p>
                            <p><b>Brand culture:</b> science, health, luxury and high quality
                            </p>
                            <p><b>Brand slogan:</b> Everyone enjoys scientific skin care
                            </p>

                        </div>
                    </div>
                </div>
            </section>
            <!-- End Customer Section -->

            <section class="pb-10 store-section appear-animate">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="mb-4 col-md-7 order-md-first">
                            <h5 class="mb-1 section-subtitle lh-2 ls-md font-weight-normal">Brand Story</h5>

                            <p class="section-desc text-grey">
                                Queen Elizabeth II of the United Kingdom visited Singapore in 2006, wearing a strapless gown
                                and a diamond crown on her head. Her face is flawless and charming. Elizabeth came to
                                Queenstown to communicate with the local people face to face. Many local women faced the
                                Queen’s demeanor and believed that Queen Elizabeth was the most beautiful woman in the
                                world. She was 80 years old and her skin was still smooth, supple, healthy and delicate.
                                Kelly You, the founder of the Xizhiyan brand, made up his mind at that time, hoping to one
                                day create a facial skin care product for women all over the world, so that women can have
                                healthy skin. This has planted a seed that needs to be germinated for the founding of
                                MYQUEEN.


                                With her dedication to "having healthy skin" and her travels overseas, and even visited the
                                UK many times, Kelly You has been looking for answers to how to have healthy skin. As a
                                result, any skin care products are not the source of healthy skin. According to well-known
                                dermatology According to the doctor, one of the things to get healthy skin is persistence
                                day after day. Even for the Queen of England, the essence of skin care is sunscreen,
                                cleansing and bedtime care.

                                Second is sun protection. Sun protection is indispensable in skin care procedures in any
                                country. In the documentary produced by the British BBC, the truth is revealed. The biggest
                                cause of wrinkles on the skin is sun exposure, which is the cause of all wrinkles. Among
                                them, sun exposure accounts for 75%, and all effective anti-aging stunts are sun protection.
                                Even in Britain, which is rainy all year round, the Queen of England also pays great
                                attention to sun protection, often wearing hats and sunglasses outdoors.

                                Furthermore, skin conditioning needs to be solved from the root cause. No organism can do
                                without water. Water is the most important element of life metabolism. Water can come from
                                daily skin care and food. Moisturizing and post-sun repair are the "source of conditioning".

                                As time passed, the time came to April 2019. In an occasional social interaction, Kelly You
                                met Dr. Eric Lim, an expert in skin care formulations, and learned that he is a well-known
                                person in the skin care industry with an independent skin laboratory and numerous skins
                                behind him. With the support of academic experts, Kelly You believes that the time has come
                                to create a healthy skin brand, and immediately the MYQUEEN brand and Xizhiyan Lab were
                                officially registered in Singapore in May 2019.
                                Determined to make the myth of agelessness of Queen Elizabeth of England happen to women all
                                over the world, this is the common vision of Kelly You and MYQUEEN brand.
                            </p>

                        </div>
                        <div class="mb-4 col-md-5">
                            <figure>
                                <img src="{{ asset('asset/image/font/brand-story.png') }}" alt="Our Store" width="580"
                                    height="507" class="banner-radius" style="background-color: #DEE6E8;" />
                            </figure>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Store-section -->

            <section class="pb-10 customer-section appear-animate">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="mb-4 col-md-5">
                            <figure>
                                <img src="{{ asset('asset/image/font/product-development.png') }}" alt="Happy Customer"
                                    width="580" height="507" class="banner-radius" style="background-color: #BDD0DE;" />
                            </figure>
                        </div>
                        <div class="mb-4 col-md-7">
                            <h5 class="section-subtitle lh-2 ls-md font-weight-normal">Product development principles:
                            </h5>

                            <p class="section-desc text-grey">
                                Naturalness, pertinence, functionality, and economy are the needs of every woman and are
                                also the criteria of the MYQUEEN brand.

                            </p>
                            <p>In the selection of raw materials, it adheres to the new-age beauty concept of "natural, safe
                                and effective", adopts a variety of advanced formulas such as green plant extracts,
                                high-tech skin care factors, and strictly eliminates raw materials that have any hidden
                                dangers in the skin.
                            </p>
                            <p>Especially for the repair and maintenance of problem skin, technical experts spare no effort
                                to study and explore. Starting from human nature, starting from human needs, is the original
                                intention of research and development of light medical beauty skin care products.
                            </p>
                            <p>Naturalness must of course be people-oriented, and comprehensive consideration must be given
                                to the relationship between people and the environment, the need for antioxidants in the
                                air, the pollution of dust to the skin, the radiation of the sun to the skin, and so on. It
                                can greatly slow down aging and enhance the youthful texture of the skin.
                            </p>


                        </div>
                    </div>
                </div>
            </section>
            <section class="pb-10 store-section appear-animate">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="mb-4 col-md-7 order-md-first">
                            <h5 class="mb-1 section-subtitle lh-2 ls-md font-weight-normal">Quality production standards
                            </h5>

                            <p class="section-desc text-grey">

                                The production management center strictly implements the standards of refined production
                                management:

                            </p>
                            <p>From the purchase and inspection of raw materials and packaging materials to the storage of
                                finished products; from the research and development of new formulas to the formal
                                production of new products; strict requirements are imposed on every detail in the
                                production process.
                            </p>
                            <p><b>The production base is also a 100,000-level purification workshop and other standards:
                                </b></p>
                            <p>Prevent outside pollution to the product and ensure the output of high-quality products.
                                MYQUEEN products come from the world's first-class sophisticated production equipment,
                                research and development testing equipment
                            </p>

                        </div>
                        <div class="mb-4 col-md-5">
                            <figure>
                                <img src="{{ asset('asset/image/font/Quality.png') }}" alt="Our Store" width="580"
                                    height="507" class="banner-radius" style="background-color: #DEE6E8;" />
                            </figure>
                        </div>
                    </div>
                </div>
            </section>
            <section class="pb-10 customer-section appear-animate">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="mb-4 col-md-5">
                            <figure>
                                <img src="{{ asset('asset/image/font/Operating-strategy.png') }}" alt="Happy Customer"
                                    width="580" height="507" class="banner-radius" style="background-color: #BDD0DE;" />
                            </figure>
                        </div>
                        <div class="mb-4 col-md-7">
                            <h5 class="section-subtitle lh-2 ls-md font-weight-normal">Operating strategy: </h5>

                            <p class="section-desc text-grey">
                                Adhering to the spirit and goal of "creating the most perfect and flawless skin in the
                                simplest and most effective way", the company has developed a series of "high-performance"
                                and "low-sensitive" professional skin care products to convey the concept of medical beauty
                                treatments to consumers At home, the person can continue the home medical beauty care and
                                skin care mechanism, and practice the concept of "simple to have good skin quality" and
                                quick-acting maintenance. In the face of the ever-changing business environment, the company
                                holds an attitude of continuous innovation and refinement, makes good use of medical
                                expertise and advanced technology, continues to increase the breadth and depth of the
                                product line, and expands the scope of product application and consumer customer groups to
                                create gains. At the same time, through the pursuit of quality and service, it will promote
                                the overall upward growth of the skin care products industry. </p>

                            <p><b>Development Strategy:
                                </b></p>
                            <p>Back to the original intention, through strategies such as focusing on consumers, innovative
                                thinking and efficiency improvement. Focus on consumers: Guided by consumer needs, we will
                                continue to develop and innovate medical beauty concept products, and provide the most
                                suitable products for different skin types to create customer satisfaction and build brand
                                loyalty.
                            </p>

                        </div>
                    </div>
                </div>
            </section>
            <section class="pb-10 store-section appear-animate">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="mb-4 col-md-7 order-md-first">
                            <h5 class="mb-1 section-subtitle lh-2 ls-md font-weight-normal">Research And Laboratory Facts:
                            </h5>

                            <p class="section-desc text-grey">
                                Adhering to the concept of skin care based on the study of plant extracts, it is committed
                                to the research of biological cell gene expression and skin physiological metabolism, as
                                well as the application and development of biological skin care products. Relying on the
                                cutting-edge technology of cell biology, dermatology, cosmetic science and other
                                disciplines, through a variety of advanced biotechnology to obtain biologically active
                                ingredients homologous to the human body, using biological gene expression and advanced
                                cosmetic science and technology to improve through regulation at the molecular level The
                                internal environment of skin growth promotes the growth of healthy cells, and eventually
                                replaces the problematic cells of aging, so that the skin presents a healthy state after
                                treatment.

                            </p>
                            <p>The original intention of establishing the laboratory was to conduct research and development
                                and production of related skin care products based on the research results on the basis of
                                in-depth research on the characteristics of female skin. Find the psychological needs of
                                consumers and provide scientific and effective products. XZY skin care laboratory has
                                gathered a large number of skin care industry veterans, medical experts, professors,
                                research and development consultants and other professionals, who have accumulated and tried
                                in women's skin care and beauty for many years. Accumulated a wealth of industry experience
                                in the production process of beauty and skin care products, and conducted in-depth
                                scientific research on the characteristics of female skin
                            </p>

                        </div>
                        <div class="mb-4 col-md-5">
                            <figure>
                                <img src="{{ asset('asset/image/font/Research-And-Laboratory-Facts.png') }}"
                                    alt="Our Store" width="580" height="507" class="banner-radius"
                                    style="background-color: #DEE6E8;" />
                            </figure>
                        </div>
                    </div>
                </div>
            </section>
            <section class="pb-10 customer-section appear-animate">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="mb-4 col-md-5">
                            <figure>
                                <img src="{{ asset('asset/image/font/Biological-health-research.png') }}"
                                    alt="Happy Customer" width="580" height="507" class="banner-radius"
                                    style="background-color: #BDD0DE;" />
                            </figure>
                        </div>
                        <div class="mb-4 col-md-7">
                            <h5 class="section-subtitle lh-2 ls-md font-weight-normal">Biological health research:
                            </h5>

                            <p class="section-desc text-grey">
                                <b>Research on innovative raw materials</b>
                            </p>
                            <p>Utilizing the abundant natural raw material resources at home and abroad, using experimental
                                extraction and separation technology, developing new active ingredients, researching new
                                skin care products raw materials, constructing multiple active screening mechanisms, and
                                formulating raw material quality standards.
                            </p>

                            <p><b>Activity and mechanism research
                                </b>Construct rational activity research steps, systematically explain different dimensions,
                                form a verifiable proposition system, formulate biological activity and mechanism of action
                                and safety evaluation, and replace experimental research.
                            </p>

                            <p><b>Formulation and process research
                                </b> Research on new cosmetic excipients, bioequivalence research, process adaptability and
                                stability, cosmetic safety, effectiveness and quality evaluation method research, innovative
                                formulation application research, new cosmetic development, etc.
                            </p>

                            <p><b>Industrialization platform research
                                </b>The frontier of skin biology, strong academic background and scientific research
                                advantages are efficiently transformed into social value, the application of new materials,
                                the pilot test of new formulas and processes, the transfer of patents and technology.
                            </p>

                            <p> <b>Skin health aesthetics research
                                </b> Carry out biological skin care research, teach scientific skin care concepts and
                                methods, achieve high-quality experience and skin health, use science to achieve aesthetics,
                                and pursue a healthy and beautiful state in the structure, form, physiological function, and
                                mental processes of the human body.
                            </p>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
@section('javascript')
    <script>
        $(document).ready(function() {
            setTimeout(() => {
                $('body').addClass('mainloaded')
            }, [1000])
        });
    </script>
@endsection
@endsection
