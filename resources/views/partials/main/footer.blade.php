<footer class="footer">

  <div class="footer-top">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 col-12">
          <div class="single-footer f-contact">
            <img class="footer-logo" src="{{asset('images/logo-light.svg')}}" alt="Logo">
            <ul>
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita, sunt eum, veniam nesciunt iste dicta ipsam eius molestiae dolor rem pariatur accusantium, magni culpa atque.</li>
              <li>Alamat : <span id="footer-alamat">{{$company_profile->alamat}}</span> <br>
                Telpon : <span id="footer-telp">{{$company_profile->no_telp}}</span><br>
                Whatsapp : <a id="footer-wa" href="https://wa.me/{{$company_profile->whatsapp}}">{{$company_profile->whatsapp}}</a><br>
                Email : <a id="footer-email" href="mailto:{{$company_profile->email}}">{{$company_profile->email}}</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
          <div class="single-footer f-link">
            <h3>Bantuan dan Panduan</h3>
            <ul>
              <li><a href="javascript:void(0)">Tentang Kami </a></li>
              <li><a href="javascript:void(0)">Hubungi Kami </a></li>
              <li><a href="javascript:void(0)">FAQ</a></li>
              <li><a href="javascript:void(0)">Syarat dan Ketentuan</a></li>
              <li><a href="javascript:void(0)">Kebijakan Privasi</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
          <div class="single-footer f-link">
            <h3>Jelajah</h3>
            <ul>
              <li><a href="{{route('cart.index')}}">Cart</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>