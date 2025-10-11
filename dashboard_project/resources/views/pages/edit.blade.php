<!doctype html>
<body>
       <div class="text-center">
        <p>Update User Details</p>
      </div>

      <div class="container">
        <form method="POST" action="{{ route('editStore') }}">
          @csrf
            <input type="text" name="user_id" hidden value="{{ $user->id }}"> 
            
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Name</label>
              <input type="text" name="name" class="form-control"  required value="{{ $user->name }}"> 
            </div>
            
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label> 
                <input type="email" name="email" class="form-control"  required value="{{ $user->email }}"> 
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password (Leave blank to keep old password)</label> 
                <input type="password" name="password" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
      </div>
    </body>
</html>