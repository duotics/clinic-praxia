{if $showBottom}
<nav class="navbar fixed-bottom bg-light mt-3">
    <div class="container-fluid">
        <small class="badge bg-light">{$APP_COPY}</small>
        <small class="badge bg-light">{$APP_ENV}</small>
        <small class="text-muted">
        <span class="d-block d-sm-none">xs (< 576px)</span>
        <span class="d-none d-sm-block d-md-none">sm (576px - 768px)</span>
        <span class="d-none d-md-block d-lg-none">md (768px - 992px)</span>
        <span class="d-none d-lg-block d-xl-none">lg (992px - 1200px)</span>
        <span class="d-none d-xl-block d-xxl-none">xl (1200px - 1400px)</span>
        <span class="d-none d-xxl-block">xxl (> 1400px)</span>
        </small>
        <small class="badge bg-light">TEMA: {$bsTheme}</small>
    </div>
</nav>
{/if}
</body>
</html>