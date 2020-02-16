@extends('layouts.master')

@section('content')

@include('partials.masthead')

  <!-- Portfolio Section -->
  <section class="page-section portfolio" id="portfolio">
    <div class="container">

      <!-- Portfolio Section Heading -->
      <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Proyectos</h2>

      <!-- Icon Divider -->
      <div class="divider-custom">
        <div class="divider-custom-line"></div>
      </div>

      <!-- Portfolio Grid Items -->
      <div class="row">

      @foreach( $proyectos as $key => $proyecto )
        <!-- Portfolio Item -->
        <div class="col-md-6 col-lg-4">
          <div class="portfolio-item mx-auto" data-toggle="modal" data-target="#portfolioModal{{$key+1}}">
            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
              <div class="portfolio-item-caption-content text-center text-white">
                <i class="fas fa-plus fa-3x"></i>
              </div>
            </div>
            <img class="img-fluid" src="{{ secure_url('https://raul-portfolio-storage.s3.eu-west-3.amazonaws.com/proyectos/'.$proyecto->foto)}}" alt="Portada">
          </div>
        </div>

        <!-- Portfolio Modal -->
        <div class="portfolio-modal modal fade" id="portfolioModal{{$key+1}}" tabindex="-1" role="dialog" aria-labelledby="portfolioModal{{$key}}Label" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                  <i class="fas fa-times"></i>
                </span>
              </button>
              <div class="modal-body text-center">
                <div class="container">
                  <div class="row justify-content-center">
                    <div class="col-lg-8">
                      <!-- Portfolio Modal - Title -->
                      <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">{{$proyecto->nombre}}</h2>
                      <!-- Icon Divider -->
                      <div class="divider-custom">
                        <div class="divider-custom-line"></div>
                      </div>
                      <!-- Portfolio Modal - Image -->
                      <img class="img-fluid rounded mb-5" src="{{ secure_url('https://raul-portfolio-storage.s3.eu-west-3.amazonaws.com/proyectos/'.$proyecto->foto)}}" alt="Portada">
                      <!-- Portfolio Modal - Text -->
                      <p class="mb-5">{{$proyecto->fecha}}</p>
                      <p class="mb-5">{{$proyecto->descripcion}}</p>
                      <button class="btn btn-primary" href="#" data-dismiss="modal">
                        <i class="fas fa-times fa-fw"></i>
                        Close Window
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
      </div>
      <!-- /.row -->

    </div>
  </section>

  <!-- About Section -->
  <section class="page-section bg-primary text-white mb-0" id="about">
    <div class="container">

      <!-- About Section Heading -->
      <h2 class="page-section-heading text-center text-uppercase text-white">Info</h2>

      <!-- Icon Divider -->
      <div class="divider-custom divider-light">
        <div class="divider-custom-line"></div>
      </div>

      <!-- About Section Content -->
      <div class="row">
        <div class="col-lg-4 ml-auto">
          <p class="lead">Soy un apasionado de la programación, desarrollador web Full-Stack aunque especializado en el Back-End. Mis proyectos son hechos con mucho cariño e ilusión.</p>
        </div>
        <div class="col-lg-4 mr-auto">
          <p class="lead">A pesar de ser Junior, tengo conocimientos sobre muchas tecnologías, las principales: PHP, Node.js, MySQL/MariaDB, MongoDB, HTML, CSS, Javascript y entornos LAMP.</p>
        </div>
      </div>

      <!-- About Section Button -->
      <div class="text-center mt-4">
        <a class="btn btn-xl btn-outline-light" href="pdf/curriculum.pdf" target="_blank">
          <i class="fas fa-download mr-2"></i>
          Mi curriculum!
        </a>
      </div>

    </div>
  </section>

  <!-- Contact Section -->
  <section class="page-section" id="contact">
    <div class="container">

      <!-- Contact Section Heading -->
      <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Contacto</h2>

      <!-- Icon Divider -->
      <div class="divider-custom">
        <div class="divider-custom-line"></div>
      </div>

      <!-- Contact Section Form -->
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
          <form name="sentMessage" id="contactForm" novalidate="novalidate">
            <div class="control-group">
              <div class="form-group floating-label-form-group controls mb-0 pb-2">
                <label>Nombre</label>
                <input class="form-control" id="name" type="text" placeholder="Nombre" required="required" data-validation-required-message="Please enter your name.">
                <p class="help-block text-danger"></p>
              </div>
            </div>
            <div class="control-group">
              <div class="form-group floating-label-form-group controls mb-0 pb-2">
                <label>Email</label>
                <input class="form-control" id="email" type="email" placeholder="Email" required="required" data-validation-required-message="Please enter your email address.">
                <p class="help-block text-danger"></p>
              </div>
            </div>
            <div class="control-group">
              <div class="form-group floating-label-form-group controls mb-0 pb-2">
                <label>Teléfono</label>
                <input class="form-control" id="phone" type="tel" placeholder="Teléfono" required="required" data-validation-required-message="Please enter your phone number.">
                <p class="help-block text-danger"></p>
              </div>
            </div>
            <div class="control-group">
              <div class="form-group floating-label-form-group controls mb-0 pb-2">
                <label>Mensaje</label>
                <textarea class="form-control" id="message" rows="5" placeholder="Mensaje" required="required" data-validation-required-message="Please enter a message."></textarea>
                <p class="help-block text-danger"></p>
              </div>
            </div>
            <br>
            <div id="success"></div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary btn-xl" id="sendMessageButton">Enviar</button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </section>

@stop