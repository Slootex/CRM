<!DOCTYPE html>
<html lang="en">
  <head><title>CRM P+</title>
    <title>Steuergeräte Steubel - Online Auftragsformular</title>
    <meta name="description" content="Steuergeräte Prüfung, Reparatur oder Austauschgeräte für alle Fahrzeuge und alle Hersteller. Techniker-Hotline: 0421-59564922" />
    <link rel="icon" href="/assets/images/cover-images/fav.png" />

    <!-- Required Meta Tags-->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--Required Stylesheet Links-->
    <link type="text/css" rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/css/smart-wizard-all.min.css" />
    <link type="text/css" rel="stylesheet" href="/assets/css/styles.css" />
    <link rel="stylesheet" href="/assets/css/responsive.css" />
  </head>

  <body>
    <!--HEADER START-->
    <header>
      <nav class="navbar navbar-expand-lg">
        <div class="container">
        <a class="navbar-brand" href="/"><img src="/assets/images/cover-images/Logo.png" alt="" style="width: 20rem; height: 5.5rem;" /></a>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse-nav-srch-wrap">
            <div class="nav-test">
              <div class="navbar-collapse" id="navbarSupportedContent">
                <ul class="align-items-center mb-2 mb-lg-0 ms-auto navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link" href="/motor_steuergeraet">Motor-Steuergerät</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/abs_steuergeraet">ABS-Steuergerät</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a
                      class="nav-link dropdown-toggle"
                      href="#"
                      id="navbarDropdown"
                      role="button"
                      data-bs-toggle="dropdown"
                      aria-expanded="false"
                    >
                      Fahrzeuge
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <li><a class="dropdown-item" href="/fahrzeug_marke">Car</a></li>
                      <li><a class="dropdown-item" href="/vehicles_truck">Truck</a></li>
                      <li><a class="dropdown-item" href="/vehicles_motorcycle">Motorcycle</a></li>
                      <li><a class="dropdown-item" href="/vehicles_buses">Buses</a></li>
                      <li><a class="dropdown-item" href="/fahrzeug_marke">Car</a></li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="/reparaturprozess" class="custom-btn nav-btn bg-fill">Reparaturservice</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="position-relative">
              <div class="srch-btn contain-image search-icon">
                <i data-icon="navsearch"></i>
              </div>
              <div class="srch-box" style="display: none">
                <input
                  type="search"
                  class="form-control custom-input"
                  placeholder="Search"
                />
                <button type="submit">Suchen</button>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </header>
    <!--HEADER END-->
<form action="{{url("/")}}/api/post/neuer-auftrag" id="finalpost" enctype="multipart/form-data" method="POST">
    <section class="order-form-section pb-0">
      <div class="container">
        <div class="order-form-title">
          Steuergeräte Steubel - Steuergeräte Auftragsformular
        </div>
        <div id="smartwizard" class="form-smart-wizard">
          <ul class="nav">
            <li>
              <a class="nav-link" href="#step-1">
                <div class="nav-step-wrap">
                  <div class="nav-step-icon"><i data-icon="Location"></i></div>
                  <div class="nav-step-text"><span>01</span>Adresse</div>
                </div>
              </a>
            </li>
            <li>
              <a class="nav-link" href="#step-2">
                <div class="nav-step-wrap">
                  <div class="nav-step-icon"><i data-icon="OrderData"></i></div>
                  <div class="nav-step-text"><span>02</span>Auftragsdaten</div>
                </div>
              </a>
            </li>
            <li>
              <a class="nav-link" href="#step-3">
                <div class="nav-step-wrap">
                  <div class="nav-step-icon"><i data-icon="Confirm"></i></div>
                  <div class="nav-step-text"><span>03</span>Bestätigen</div>
                </div>
              </a>
            </li>
          </ul>

          <div class="tab-content">
            <div id="step-1" class="tab-pane" role="tabpanel">
              <div class="order-form-one">
                <div class="order-form-wrap d-block d-md-none">
                  <h3 class="fw-600 text-center">Ich beauftrage als</h3>
                </div>
                <div class="order-form-wrap bg-w">
                  <div class="radio-wrap rmw d-flex flex-wrap">
                    <div class="form-check">
                      <input
                        class="form-check-input"
                        type="radio"
                        name="type"
                        id="flexRadioDefault1"
                        value="Privatperson"
                      />
                      <label class="form-check-label" for="flexRadioDefault1">
                        Privatperson
                      </label>
                    </div>
                    <div class="form-check">
                      <input
                        class="form-check-input"
                        type="radio"
                        name="type"
                        id="flexRadioDefault2"
                        value="Firma"
                        checked
                      />
                      <label class="form-check-label" for="flexRadioDefault2">
                        Firma
                      </label>
                    </div>
                  </div>
                </div>
                <div class="order-form-wrap p-50">
                  <div class="row p-30">
                    <div class="col-12 col-md-7">
                      <h3 class="fw-600 mb-2 mb-sm-3 mb-md-0">Anrede</h3>
                    </div>
                    <div class="col-12 col-md-5">
                      <div
                        class="radio-wrap justify-content-between justify-content-md-evenly"
                      >
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="gender"
                            id="flexRadioDefault3"
                            value="Herr"
                          />
                          <label
                            class="form-check-label"
                            for="flexRadioDefault3"
                          >
                            Herr
                          </label>
                        </div>
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="gender"
                            id="flexRadioDefault4"
                            value="Frau"
                            checked
                          />
                          <label
                            class="form-check-label"
                            for="flexRadioDefault4"
                          >
                            Frau
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <label for="name" class="p-10"
                      >Name <span class="gs">*</span></label
                    >
                    <div class="col-12 col-md-6">
                      <div class="form-group">
                        <input
                          type="text"
                          class="custom-input form-control"
                          placeholder="Vorname"
                          name="firstname"
                        />
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="form-group">
                        <input
                          type="text"
                          class="custom-input form-control"
                          placeholder="Nachname"
                          name="lastname"
                        />
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="form-group">
                        <label for="name" class="p-10"
                          >Email <span class="gs">*</span></label
                        >
                        <input
                          type="text"
                          class="custom-input form-control"
                          placeholder=""
                          name="email"
                        />
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="form-group">
                        <label for="name" class="p-10">Telefon</label>
                        <input
                          type="number"
                          class="custom-input form-control"
                          placeholder=""
                          name="phone"
                        />
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="form-group">
                        <label for="number" class="p-10">Mobil</label>
                        <input
                          type="number"
                          class="custom-input form-control"
                          name="mobile"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <label for="name" class="p-10"
                      >Adresse <span class="gs">*</span></label
                    >
                    <div class="col-12 col-md-6 col-lg-8">
                      <div class="form-group">
                        <input
                          type="text"
                          class="custom-input form-control"
                          placeholder="Straße"
                          name="street"
                        />
                      </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                      <div class="form-group">
                        <input
                          type="text"
                          class="custom-input form-control"
                          placeholder="Nummer"
                          name="streetno"
                        />
                      </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                      <div class="form-group">
                        <input
                          type="text"
                          class="custom-input form-control"
                          placeholder="Postleitzahl"
                          name="zipcode"
                        />
                      </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-5">
                      <div class="form-group">
                        <input
                          type="text"
                          class="custom-input form-control"
                          placeholder="Stadt"
                          name="city"
                        />
                      </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                      <div class="form-group">
                        <select name="country" class="form-select custom-input">
                          <option value="Germany">Deutschland</option>
                          <option value="Great Britain">Great Britain</option>
                          <option value="Italy">Italy</option>
                          <option value="Lithuania">Lithuania</option>
                          <option value="Luxembourg">Luxembourg</option>
                          <option value="Netherlands">Netherlands</option>
                          <option value="Austria">Austria</option>
                          <option value="Poland">Poland</option>
                          <option value="Switzerland">Switzerland</option>
                          <option value="Spain">Spain</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="order-form-wrap">
                  <div
                    class="checkbox-wrap d-flex align-items-center justify-content-between"
                  >
                    <h3 class="fw-600 mb-0">
                      <span class="gs">Abweichende Rücksendeadresse</span>
                    </h3>
                    <div class="form-check">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        value=""
                        id="flexCheckDefault"
                      />
                      <label class="form-check-label" for="flexCheckDefault">
                        Ja
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="step-2" class="tab-pane" role="tabpanel">
              <div class="order-form-two">
                <div class="order-form-wrap p-50">
                  <h3 class="fw-600 p-30">Fahrzeugdaten</h3>
                  <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <input
                              type="text"
                              class="custom-input form-control"
                              placeholder="Automarke"
                              name="marke"
                            />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="form-group">
                        <div class="form-group">
                            <input
                              type="text"
                              class="custom-input form-control"
                              placeholder="Automodel"
                              name="model"
                            />
                          </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="form-group">
                        <div class="form-group">
                            <input
                              type="text"
                              class="custom-input form-control"
                              placeholder="Baujahr"
                              name="year"
                            />
                          </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="form-group">
                        <input
                          type="text"
                          class="custom-input form-control gs"
                          placeholder="Fahrzeug Identifikationsnummer"
                          name="vin"
                        />
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="form-group">
                        <input
                          type="text"
                          class="custom-input form-control gs"
                          placeholder="Fahrleistung (PS)"
                          name="power"
                        />
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="form-group">
                        <input
                          type="number"
                          class="custom-input form-control"
                          placeholder="Kilometerstand"
                          name="mileage"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row gy-3">
                    <div class="col-12 col-md-6">
                      <h3 class="fw-600 p-20">Getriebe</h3>
                      <div class="radio-wrap d-flex justify-content-start">
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="getriebe"
                            id="flexRadioDefault5"
                            value="Schaltung"
                          />
                          <label
                            class="form-check-label"
                            for="flexRadioDefault5"
                          >
                            Schaltung
                          </label>
                        </div>
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="getriebe"
                            value="Automatik"
                            id="flexRadioDefault6"
                            checked
                          />
                          <label
                            class="form-check-label"
                            for="flexRadioDefault6"
                          >
                            Automatik
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <h3 class="fw-600 p-20">Kraftstoffart</h3>
                      <div class="radio-wrap d-flex justify-content-start">
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="fuel"
                            id="flexRadioDefault7"
                            value="Benzin"
                          />
                          <label
                            class="form-check-label"
                            for="flexRadioDefault7"
                          >
                            Benzin
                          </label>
                        </div>
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="fuel"
                            value="Diesel"
                            id="flexRadioDefault8"
                            checked
                          />
                          <label
                            class="form-check-label"
                            for="flexRadioDefault8"
                          >
                            Diesel
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr />
                  <div class="row">
                    <h3 class="fw-600 p-30">Gerätedaten</h3>
                    <div class="col-12 col-md-6">
                      <div class="form-group">
                        <select name="broken_comp" class="form-select custom-input" required>
                          <option value="" disabled selected>
                            Defektes Steuergerät
                          </option>
                        
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="form-group">
                        <div class="form-group">
                            <input
                              type="text"
                              class="custom-input form-control gs"
                              placeholder="Gerätehersteller"
                              name="comp_company"
                            />
                          </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="form-group">
                        <div class="form-group">
                        <input
                          type="text"
                          class="custom-input form-control gs"
                          placeholder="Fahrleistung (PS)"
                          name="power"
                        />
                      </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <h3 class="fw-600 py-4">
                      Stammt das Gerät aus dem angegebenen Fahrzeug?
                    </h3>
                    <div class="col-12 col-md-6">
                      <div class="radio-wrap d-flex justify-content-start">
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="from_car"
                            id="flexRadioDefault9"
                            value="Ja"
                          />
                          <label
                            class="form-check-label"
                            for="flexRadioDefault9"
                          >
                            Ja
                          </label>
                        </div>
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="from_car"
                            id="flexRadioDefault10"
                            value="Nein"
                            checked
                          />
                          <label
                            class="form-check-label"
                            for="flexRadioDefault10"
                          >
                            Nein
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="order-form-wrap p-50">
                  <h3 class="fw-600 pb-4">Fehlerbeschreibung</h3>
                  <div class="row">
                    <div class="col-12 col-md-6">
                      <textarea
                        placeholder="Cause of error/which functions do not work? "
                        rows="8"
                        cols="15"
                        class="w-100"
                        name="error_message"
                      >
                      </textarea>
                    </div>
                    <div class="col-12 col-md-6">
                      <textarea
                        rows="8"
                        placeholder="What has already been done to the vehicle?  Error memory read (code/text)? "
                        cols="15"
                        class="w-100"
                        name="error_cache"
                      >
                      </textarea>
                    </div>
                  </div>
                </div>
                <div class="order-form-wrap">
                  <div class="row">
                    <div class="col-12 col-md-6 text-center text-md-start gs">
                      <h3 class="fw-600">Dateien von der Festplatte hinzufügen</h3>
                      <span>(Sie können 5 Dateien hochladen.)</span>
                    </div>
                    <div class="col-12 col-md-6">
                      <div
                        class="file-choose text-center text-md-end mt-3 mt-md-0"
                      >
                        <input type="file" name="files[]" onchange="document.getElementById('file-text').innerHTML = this.files.length + ' Datein'" multiple id="myfile" />
                        <label class="file-choose-lable" for="myfile">
                          <span
                            ><img
                              src="assets/images/graphics/filechoose.svg"
                              alt="filechoose"
                          /></span>
                          <span class="choose-text" id="file-text">Datei wählen</span></label
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="step-3" class="tab-pane" role="tabpanel">
              <div class="order-form-three">
                <div class="order-form-wrap">
                  <div class="row gy-3">
                    <div class="col-12 col-lg-6">
                      <h3 class="fw-600 p-20">Rücksendung</h3>
                      <div
                        class="radio-wrap d-flex justify-content-start flex-wrap"
                      >
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="shipping"
                            id="flexRadioDefault11"
                            value="Standard"
                          />
                          <label
                            class="form-check-label"
                            for="flexRadioDefault11"
                          >
                            Standardversand
                          </label>
                        </div>
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="shipping"
                            id="flexRadioDefault12"
                            value="Express"
                            checked
                          />
                          <label
                            class="form-check-label"
                            for="flexRadioDefault12"
                          >
                            Expressversand
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-lg-6">
                      <h3 class="fw-600 p-20">Zahlungsweise</h3>
                      <div
                        class="radio-wrap d-flex justify-content-start flex-wrap"
                      >
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="payment"
                            id="flexRadioDefault13"
                            value="Barzahlung"
                          />
                          <label
                            class="form-check-label"
                            for="flexRadioDefault13"
                          >
                            Barzahlung
                          </label>
                        </div>
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="payment"
                            id="flexRadioDefault14"
                            value="Überweisung"
                            checked
                          />
                          <label
                            class="form-check-label"
                            for="flexRadioDefault14"
                          >
                            Überweisung
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <h3 class="fw-600 p-20">
                        Allgemeine Geschäftsbedingungen
                        <span class="gs">*</span>
                      </h3>
                      <div class="step-wrap d-flex">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          value=""
                          id="flexCheckDefaultp"
                        />
                        <label class="form-check-label" for="flexCheckDefaultp">
                          I certify that the above information is true. I have
                          read the terms and <a href="#">Conditions</a> /
                          customer information of Steuergeräte Steubel and by submitting
                          the form I declare my order for error diagnosis for
                          the enclosed device(s). I have taken note of the
                          cancellation policy(s) / the
                          <a href="#">model cancellation form</a>.
                        </label>
                      </div>
                    </div>

                    <div class="col-12">
                      <h3 class="fw-600 p-20">
                        privacy <span class="gs">*</span>
                      </h3>
                      <div class="step-wrap d-flex">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          value=""
                          id="flexCheckDefaultq"
                        />
                        <label class="form-check-label" for="flexCheckDefaultq">
                          I have taken note of the
                          <a href="#">data protection</a> declaration.
                        </label>
                      </div>
                    </div>
                    <div class="col-12">
                      <h3 class="fw-600 p-20">
                        Captcha <span class="gs">*</span>
                      </h3>
                      <div class="captchar-wrap">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          value=""
                          id="flexCheckDefaultr"
                        />
                        <label class="form-check-label" for="flexCheckDefaultr">
                          Ich bin kein Roboter
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</form>
    <!--FOOTER START-->
    <footer>
      <div class="footer-top">
        <div class="container">
          <div class="row g-3">
            <div class="col-12 col-sm-6 col-lg-3">
              <div class="footer-top-wrap">
                <div class="fw d-flex flex-column">
                <a href="javascript:void(0)"><img src="/assets/images/cover-images/logo_footer.png" alt="" style="height: 2.5rem; width: 10rem;" /></a>
                  <p>
                    Steuergeräte Steubel Mail Boxes Etc. Violenstrasse 37, 28195 Bremen
                  </p>
                  <div class="adv-logo-wrap">
                    <div class="adv-logo-wrap-img">
                      <img
                        src="/assets/images/cover-images/T.png"
                        class="py-2"
                        alt="trustpilot"
                      />
                    </div>
                    <div class="adv-logo-wrap-img">
                      <img
                        src="/assets/images/cover-images/G.png"
                        alt="google"
                        class="py-2"
                      />
                    </div>
                    <div class="adv-logo-wrap-img">
                      <img
                        src="/assets/images/cover-images/P.png"
                        alt="provenExpert"
                        class="py-2"
                      />
                    </div>
                  </div>
                  <a href="/assets/vcard.vcf" class="custom-btn medium-btn bg-fill ft-btn mt-2"
                    ><i data-icon="download" class="me-1 me-lg-3 py-2"></i
                    >V.Card Download
                  </a>
                </div>
              </div>
            </div>
            <div class="col-6 col-sm-6 col-lg-3">
              <div class="info-footer-top-wrap">
                <h4>Information</h4>
                <ul class="footer-wrap">
                  <li><a href="/impressum">Impressum</a></li>
                  <li><a href="/widerrufsrecht">Widerrufsrecht</a></li>
                  <li><a href="/widerrufsbelehrung">Widerrufsbelehrung</a></li>
                  <li><a href="/haftungsausschluss">Haftungsausschluss</a></li>
                  <li><a href="/datenschutz">Datenschutz</a></li>
                  <li><a href="/kontakt">Kontakt</a></li>
                  <li><a href="/agb">AGBs</a></li>
                </ul>
              </div>
            </div>
            <div class="col-6 col-sm-6 col-lg-3">
              <div class="info-footer-top-wrap">
                <h4>Entdecken</h4>
                <ul class="footer-wrap">
                  <li><a href="/motor_steuergeraet">Motor-Steuergerät</a></li>
                  <li><a href="/airbag_steuergeraet">Airbag-Steuergerät</a></li>
                  <li><a href="/chiptuning_steuergeraet">Chiptuning-Steuergerät</a></li>
                  <li><a href="/abs_steuergeraet">ABS-Steuergerät</a></li>
                  <li><a href="/sbc_einheit_mercedes">SBC-Einheit Mercedes</a></li>
                  <li><a href="/wegfahrsperre_loeschen">Wegfahrsperre löschen</a></li>
                  <li><a href="/sonstige_geraete">Sonstige Geräte</a></li>
                  <li><a href="/ecu_blog">Steuergeräte Blog</a></li>
                </ul>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
              <div class="inner-info">
                <div class="footer-inner-wrap">
                  <h4>Kontakt</h4>
                  <ul class="info-test">
                    <li>
                      <div class="in-icon me-2 me-sm-3">
                        <i data-icon="phone"></i>
                      </div>
                      <a href="tel:0421 59 56 49 22">0421 59 56 49 22</a>
                    </li>
                    <li>
                      <div class="in-icon me-2 me-sm-3">
                        <i data-icon="mail"></i>
                      </div>
                      <a href="mailto:info@steubel.de"
                        >info<span class="gs">@</span>steubel.de</a
                      >
                    </li>
                  </ul>
                </div>
                <div class="footer-inner-wrap general-info pt-0 pt-sm-4">
                  <h4>General</h4>
                  <ul class="footer-wrap">
                    <li><a href="/online_auftragsformular">Online Auftragsformular</a></li>
                    <li><a href="/pdf_auftragsformular.pdf">PDF Auftragsformular</a></li>
                    <li><a href="/reparaturprozess">Reparaturprozess</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="footer-icon">
            <a href="#">
              <div class="footer-icon-wrap mb-2">
                <i data-icon="phone"></i>
              </div>
            </a>
            <a href="#">
              <div class="footer-icon-wrap">
                <i data-icon="mail"></i>
              </div>
            </a>
          </div>
        </div>
      </div>
      <div class="footer-bottom fb">
        <span>Copyright © 2021 Steuergeräte Steubel All Right Of Reserved</span>
      </div>
    </footer>
    <!--FOOTER END-->

    <!--Required Script Links-->
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/smartwizard.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/custom.js"></script>

    <style>
        .button-sub {
            padding: 14px 70px;
    color: var(--color-white);
    background-color: var(--primary);
    border: 1px solid var(--primary);
    font-size: 25px;
    font-weight: 500;
    border-radius: 115px;
    transition: 0.8s all;
    margin-left: .4rem;
        }
    </style>

    <script>
         var btnFinish = $('<button></button>').text('Absenden')
                                  .addClass(' button-sub  d-none')
                                  .on('click', function(){ document.getElementById('finalpost').submit() });

      $(document).ready(function () {
        var wizard = $("#smartwizard").smartWizard({
          selected: 0,
          theme: "default",
          autoAdjustHeight: true,
          enableFinishButton: false,
          backButtonSupport: true,
          labelFinish:'Finish',
          transition: {
            animation: "none",
            speed: "400",
          },
          toolbarSettings: {
            toolbarPosition: "bottom",
            toolbarButtonPosition: "center",
            showNextButton: true,
            showPreviousButton: true,
            toolbarExtraButtons: [btnFinish],
          },
        });

        //The code for the final step
  $(wizard).on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
    if(stepDirection == "2") //here is the final step: Note: 0,1,2
    {
        $('.sw-btn-next').addClass('d-none');
        $('.button-sub').removeClass('d-none');
    }
    else
    {
        $('.sw-btn-next').removeClass('d-none');
        $('.button-sub').addClass('d-none');
    }
});
      });
    </script>
  </body>
</html>
