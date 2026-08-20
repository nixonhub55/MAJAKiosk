@extends('layouts.admin') <!-- main layout file -->

@section('content')  
<style>
        
    .container {
        width: 100%;
        margin: 0 auto;
        background-color: white;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius:5px;
    }
    h1 {
        text-align: center;
    }
    .toolbar {
        margin-bottom: 15px;
    }
    .toolbar button {
        padding: 10px;
        margin: 0 5px;
        cursor: pointer;
        font-size: 16px;
    }
    .editor {
        border: 1px solid #ccc;
        min-height: 500px;
        padding: 10px;
        font-size: 16px;
        background-color: #fff;
        overflow-y: auto;
        position: relative;
    }
    .publish-btn {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        font-size: 16px;
        cursor: pointer;
        margin-top: 20px;
    }
    .publish-btn:hover {
        background-color: #0056b3;
    }
    #fileInput {
        display: none;
    }
    #fileInput2 {
        display: none;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 10px 0;
    }
    table, th, td {
        border: 1px solid #ddd;
    }
    th, td {
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f4f4f4;
    }

    .editor ul, .editor ol {
        list-style-position: inside;
    }

    .editor li {
        display: list-item;
    }

    .editor img {
        display: inline-block;
        max-width: 100%;
        margin: 10px;
    }

    .editor img[style*="text-align: left"] {
        margin-right: 10px;
    }

    .editor img[style*="text-align: right"] {
        margin-left: 10px;
    }

    .editor img[style*="text-align: center"] {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .btn_rebon {
        text-decoration: none;
        margin-left: 20px;
        cursor: pointer;
        border:0;
        background-color: white;
    }

            
    .file-menu {
        position: relative;
        display: inline-block;
    }

    .file-label {
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
    }

    .file-toggle {
        display: none;
    }

    
    .file-dropdown {
        display: none;
        position: absolute;
        top: 30px;
        left: 0;
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        min-width: 160px;
        z-index: 1;
    }

    .file-option {
        padding: 8px 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .file-option:hover {
        background-color: #f1f1f1;
    }

    
    .file-toggle:checked + .file-dropdown {
        display: block;
    }


</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<br>

<div id="editableArea" class="editor"></div> 
</div>
    
<script>
    document.getElementById("editableArea").innerHTML  = <?=json_encode($content['rows'][0]->content)?>;
</script>
@endsection