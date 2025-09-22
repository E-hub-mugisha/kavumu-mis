<footer class="footer">
  <div class="card">
    <div class="card-body">
      <div class="d-sm-flex justify-content-center justify-content-sm-between py-2">
        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <a
            href="#" target="_blank">{{ config('app.name')}} </a>{{ \Carbon\Carbon::now()->format('l, d M Y h:i A') }}</span>
        
      </div>
    </div>
  </div>
</footer>