
<div class="modal-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2 class="title mb-2">Autentificare</h2>

                <div class="mb-1">
                    <label for="login-email">Email <span class="required">*</span></label>
                    <input type="email" class="form-input form-wide mb-2" id="login-email" required />

                    <label for="login-password">Parola <span class="required">*</span></label>
                    <input type="password" class="form-input form-wide mb-2" id="login-password" required />

                    <div class="form-footer">
                        <button onclick="checkCredentials()" class="btn btn-primary btn-md" type="submit">AUTENTIFICARE</button>

                        <div class="custom-control custom-checkbox login-persistent form-footer-right">
                            <input type="checkbox" class="custom-control-input" id="login-persistent">
                            <label class="custom-control-label form-footer-right" for="login-persistent">Tine-ma minte</label>
                        </div>
                    </div><!-- End .form-footer -->
                    <a href="/am-uitat-parola" class="forget-password"> Ai uitat parola?</a>
                </div>
            </div><!-- End .col-md-6 -->

            <div class="col-md-6">
                <h2 class="title mb-2">Inregistrare</h2>

                <div>
                 
                    <label for="register-name">Nume <span class="required">*</span></label>
                    <input type="text" class="form-input form-wide mb-2 " id="register-name" required>
    
                    <label for="register-lastName">Prenume <span class="required">*</span></label>
                    <input type="text" class="form-input form-wide mb-2 " id="register-lastName" required>
               
                    
                    <label for="register-email">Email <span class="required">*</span></label>
                    <input type="email" class="form-input form-wide mb-2" id="register-email" required>

                    <label for="register-phone">Telefon </label>
                    <input type="tel" class="form-input form-wide mb-2" id="register-phone">

                    <label for="register-password">Parola <span class="required">*</span></label>
                    <input type="password" class="form-input form-wide mb-2" id="register-password" required>

                    <label for="register-repeatPassword">Repeta parola <span class="required">*</span></label>
                    <input type="password" class="form-input form-wide mb-2" id="register-repeatPassword" required>

                    <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" checked id="termsAndConditions">
                                <label class="custom-control-label" style="margin-bottom: 15px" for="termsAndConditions">Prin crearea acestui cont, esti de acord cu <a href="/termeni-si-conditii">termenii si conditiile</a></label>
                        
                            </div><!-- End .custom-checkbox -->
                    <div class="form-footer">
                        <button onclick="register()" class="btn btn-primary btn-md">Inregistrare</button>

                    </div><!-- End .form-footer -->
                </div>
            </div><!-- End .col-md-6 -->
        </div><!-- End .row -->
    </div><!-- End .container -->
   <script>
        
   </script>
</div>