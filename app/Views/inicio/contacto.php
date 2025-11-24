<?php echo $this->extend('plantilla/layout');?>
<?php echo $this->section('contenido');?>
<section id="contacto" style="text-align: center; padding: 40px 16px;">
  <h2>Contacto</h2>
  <p>
    📍 Dirección: Ac. 153 # 96A - 10, Suba, Bogotá<br>
    📞 Teléfono: <a href="tel:3024221645">302 422 1645</a><br>
    📧 Email: <a href="mailto:jhonnysuan_94@outlook.com">jhonnysuan_94@outlook.com</a>
  </p>
  <div style="margin: 0 auto; max-width: 600px;">
    <iframe
      src="https://www.google.com/maps?q=Ac.+153+%23+96A+-+10,+Suba,+Bogotá&output=embed"
      width="100%" height="300" style="border:0; border-radius: 16px; box-shadow: 0 0 10px rgba(0,0,0,0.1);"
      allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
    </iframe>
  </div>
</section>

  <?php echo $this->endSection();?>

