let timeOut;
function fbtoastr(status,message,mode,time){
  if(document.getElementById('fb-toastr')){
    document.getElementById('fb-toastr').remove()
  }  
  const elem=document.createElement('div');
  elem.setAttribute('id','fb-toastr');
  document.body.appendChild(elem);
  const el=document.getElementById('fb-toastr');
  el.style.position='absolute';
  el.style.margin = 'auto';
  el.style.top = 0; 
  el.style.left = 0 
  el.style.bottom = 0; 
  el.style.right = 0;
  
  el.style.padding='15px';
  el.style.width='400px';
  el.style.height='300px';
  el.style.borderRadius='5em';
   
  /*el.style.top='50%';
  el.style.left='50%';
  el.style.marginTop='-50%';
  el.style.marginTop='-50%';
  el.style.width='100px';
  el.style.height='100px';*/
  
  //style='top: 50%; left: 50%; margin-top: -50px; margin-left: -50px; width: 100px; height: 100px;'

  el.style.fontFamily='Helvetica';
  let seconds=3000;
  let minutes=3000000; seconds=time>0?time:seconds;
/*
  let bg='#e6e6e6';
  let color='#dca39d';
  let border='box-shadow:0 0 5px 0 #e3e3e3';
  let status_icon='<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><defs><style>.cls-1{fill:#00a200;}.cls-2{fill:#fff;}</style></defs><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><circle class="cls-1" cx="7.5" cy="7.5" r="7.5"/><polyline class="cls-2" points="10.31 4 5.92 8.39 4.24 6.76 3 8.08 5.92 11 11.63 5.28 10.31 4"/></g></g></svg>';
  if(mode=='dark'){
    bg='#FFFFFF';
    color='#dca39d';
    border=''
  }
  if(status=='error'){
    status_icon='<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><defs><style>.cls-1{fill:#ee1b24;}.cls-2{fill:#fff;}</style></defs><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><circle class="cls-1" cx="7.5" cy="7.5" r="7.5"/><polygon class="cls-2" points="7.5 6.18 5.28 4 4 5.28 6.22 7.5 4.04 9.72 5.32 11 7.54 8.78 9.76 11 11.04 9.72 8.82 7.5 11.04 5.28 9.72 4 7.5 6.18"/></g></g></svg>'
  }*/
  
  el.innerHTML=`

  <div id='fb-toastr-container' style='background-color:#e6e6e6;cursor:pointer;margin: auto; padding: 10px; border: 1px solid black;'>
      
    <div style='justify-content:center;align-items:center;' >
        <style>
          #fb-toastr-close:hover .clsx-1 {
            fill:#d9dbde;
          }

          .btn {
            border-radius: 10px;
            border: 2px solid black;
            background-color: #625a5a;
            color: black;
            padding: 14px 28px;
            font-size: 14px;
            cursor: pointer;
            height: 24px;
            display: inline-flex;            
          }

          /* Gray */
          .default {
            border-color: #000000;
            color: white;
            font-weight: bold;
            text-align: center;
            align-items: center;
          }
          
          .default:hover {
            background: #7f7f7f;
            color: #d9dbde;
          }          

        </style>

        <div id='fb-toastr-icon' style='display: flex; justify-content: center; align-items: center;'>        
            <h1 style='color: #e24448; font-size: 16px; margin-bottom: 0px; text-align: center;'>${ message }</h1>
        </div>
        
        <div id='fb-toastr-close' style='display: flex; justify-content: center; align-items: center; margin-top: 20px;' onclick='closeToastr();'>
            <button class="btn default">OK</button>  
        </div>
    
      </div>
    </div>

  `;timeOut=setTimeout(()=>{closeToastr()},parseInt(minutes))
}
function closeToastr(){
  if(document.querySelector('#fb-toastr-container')){
    document.querySelector('#fb-toastr-container').remove()
  }
  clearTimeout(timeOut)
}