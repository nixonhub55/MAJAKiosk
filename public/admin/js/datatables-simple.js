window.addEventListener('DOMContentLoaded', event => {
    
    // Simple-DataTables initialization
    const datatablesSimple = document.getElementById('datatablesSimple');
    
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple, {
            searchable: true,   // Enable search box
            perPage: 5,         // Items per page
            sortable: true,     // Enable column sorting
            // fixedHeight: true   // Enable fixed table height
        });
    }

    const datatablesSimpleBio = document.getElementById('datatablesSimpleBio');
    if (datatablesSimpleBio) {
        new simpleDatatables.DataTable(datatablesSimpleBio, {
            searchable: true,
            perPage: 5,
            sortable: true
        });
    }

    const datatablesSimpleLeave = document.getElementById('datatablesSimpleLeave');
    if (datatablesSimpleLeave) {
        new simpleDatatables.DataTable(datatablesSimpleLeave, {
            searchable: true,
            perPage: 5,
            sortable: false,
            // fixedHeight: true
        });
    }

    const datatablesSimpleDtr = document.getElementById('datatablesSimpleDtr');
    if (datatablesSimpleDtr) {
        new simpleDatatables.DataTable(datatablesSimpleDtr, {
            searchable: true,
            perPage: 5,
            sortable: false,
            fixedHeight: true
        });
    }

    const datatablesSimpleLoans = document.getElementById('datatablesSimpleLoans');
    if (datatablesSimpleLoans) {
        new simpleDatatables.DataTable(datatablesSimpleLoans, {
            searchable: true,
            perPage: 5,
            sortable: false, 
        });
    }

    
});
