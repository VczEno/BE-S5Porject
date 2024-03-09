<!-- Modal New User -->
<div class="modal fade" id="exampleModal_new" tabindex="-1" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method='post' action="controller.php?action=add">
                  <div class="mb-3">
                    <label for="inputName">Name</label>
                    <input type="text" class="form-control" id="inputName" aria-describedby="emailHelp" name='name'>
                  </div>
                  <div class="mb-3">
                    <label for="inputLastName">Lastname</label>
                    <input type="text" class="form-control" id="inputLastname" aria-describedby="emailHelp" name='lastname'>
                  </div>
                  <div class="mb-3">
                    <label for="inputMail">Mail</label>
                    <input type="email" class="form-control" id="inputMail" aria-describedby="emailHelp" name='email'>
                  </div>
                  <div class="mb-3">
                    <label for="inputPass">Password</label>
                    <input type="password" class="form-control" id="inputPass" name='password'>
                  </div>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
              </form>

            </div>
          </div>
        </div>