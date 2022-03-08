 @if(!empty($string))
 <p style="text-align: left;">Detect text is: {{$string}}</p>
 @endif
 <div style="padding:10px">
     <h2>Upload Image</h2>
     <form class="" enctype="multipart/form-data" method="post" action="/upload">
         {{csrf_field()}}
         <input type="file" name="image" placeholder="select image">
         <button type="submit">Parse Text</button>
     </form>
 </div>