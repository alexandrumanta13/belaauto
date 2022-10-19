<?php 

title( 'BelaAuto &#8211; tyres and more'); meta( '');
    $sort = 12;
    $order = "DESC";
    $products = Product::Paginate("id", $order, $sort);
?>

<div class="page-wrapper">
    <?php include('./templates/header/header.php'); ?>

    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Acasa</a></li>
                    <li class="breadcrumb-item"><a href="#">Magazin</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Jante</li>
                </ol>
            </div><!-- End .container -->
        </nav>

        <div class="container">
            <h1 class="seo">Jante si accesorii – functionalitate si estetica pentru masina ta</h1>
            <p>Categoria de jante si accesorii este destinata tuturor pasionatilor de masini, cuprinzand modele variate,
                in conformitate cu dimensiunile potrivite masinii, dar si a preferintelor personale.

            </p>
            <iframe name="rims" id="rims"
                src="https://dealer.jantealuminiu.ro/configurator-aliaj-dealeri?dealer=348f9a53-970e-4f2a-b088-dc2f0c716439"
                style="width:100%;min-height:1350px;border:0px;"></iframe>
            <p>Fie ca sunt achizitionate din motive estetice sau chiar a venit timpul sa fie inlocuite, jantele pentru
                masina se incadreaza in cumparaturile necesare pentru intretinerea si imbunatatirea aspectului exterior
                al masinii.
            </p>
            <h2 class="seo">Jante auto si accesorii - recomandari pentru alegerea lor
            </h2>
            <p>
                Chiar daca esti pasionat de jante si accesorii auto si utilizezi aceste elemente pentru a infrumuseta
                aspectul exterior al masinii pe care o conduci, exista cateva recomandari de achizitie online a acestor
                produse:
            </p>
            <ol>
                <li>1. <strong>Tipul masinii:</strong> autoturism pentru condusul in oras, masina de curse sau model
                    offroad.</li>
            </ol>
            <p>
                In functie de modelul masinii conduse, jantele sunt impartite pe categorii de produse adecvate in acord
                cu aceste coordonate. In cazul in care detii un autoturism pe care il utilizezi zi de zi, pentru
                drumurile in oras, optiunile disponibile sunt numeroase si indeplinesc criteriile estetice si de
                functionalitate.
            </p>
            <ol>
                <li>2. <strong>Dimensiunile adecvate:</strong> fiecare tip de masina are specificatii clare in ceea ce
                    priveste dimensiunile admise pentru jante
                </li>
            </ol>
            <p>Reprezinta poate cel mai important aspect atunci cand cauti jante pentru masina. Asadar, verifica si cartea tehnica a masinii, acolo unde sunt specificate profilul, latimea si dimensiunile potrivite modelului.
            </p>
            <ol>
                <li>3. <strong>Alte aspecte tehnice:</strong> suruburi si gauri de fixare (prezoane)

                    priveste dimensiunile admise pentru jante
                </li>
            </ol>
            <p>Dimensiunile standard nu reprezinta intotdeauna singura modalitate dupa care te poti ghida, existand si alte aspecte si specificatii tehnice pentru ca jantele selectate sa se potriveasca modelului de masina. Pentru a fi sigur ca iti dotezi masina cu jante care confera siguranta condusului, verifica impreuna cu un membru al echipei gaurile din centrul jantelor, in cazul in care nu esti convins de acest aspect din descrierea produselor vizualizate. Alese incorect, jantele prevazute cu diametrul mai mare decat cel al butucului se pot bloca.
            </p>
            <h2 class="seo">Catalogul Bela Auto cu jante si accesorii – diversitate si inovatie pentru toate exigentele
            </h2>
            
            <p class="seo">Stim ce inseamna sa iti iubesti masina, astfel ca stocurile sunt alcatuite de o echipa de specialisti pasionati de masini. Mai stim si ca, indiferent de cat de util este un element pentru masina ta, intotdeauna te vei orienta catre cele care indeplinesc toate functiile tehnice, dar care au si o estetica aparte.
                Te invitam sa parcurgi paginile alocate pentru jante si accesorii in catalogul online, pentru a le alege pe cele care indeplinesc toate exigentele de sofer care isi respecta masina ca pe un partener in desfasurarea tuturor sarcinilor zilnice.
</p>
        </div><!-- End .container -->

        <div class="mb-5"></div><!-- margin -->
    </main><!-- End .main -->

    <?php include('./templates/footer/footer.php'); ?>
</div>

<?php include('./templates/mobile-menu/mobile-menu.php'); ?>
<?php include('./templates/success-message/success-message.php'); ?>

<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>