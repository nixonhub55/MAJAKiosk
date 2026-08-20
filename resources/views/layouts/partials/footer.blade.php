<style>
footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    background-color: #f8f9fa; 
    padding: 1rem 0; 
    box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1); 
    z-index: 100; 
    display: flex;
    justify-content: space-between; 
}

footer .container-fluid {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

footer a {
    color: #0d6efd;
    text-decoration: none; 
    padding: 0 5px; 
}
footer a:hover {
    text-decoration: underline; 
}

</style>

<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">
                Copyright &copy; <?=date('Y')?> OGIS Philippines Inc.
            </div>
            <!-- <div>
                <a href="#">Privacy Policy</a>
                &middot;
                <a href="#">Terms &amp; Conditions</a>
            </div> -->
        </div>
    </div>
</footer>

</div>