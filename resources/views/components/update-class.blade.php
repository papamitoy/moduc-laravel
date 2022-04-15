<!-- modal popup -->
<div class="modal fade" id="updateClass" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Update Class</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

        </div>
        <form action="/api/class/update" method="post" >
            @csrf
        <div class="modal-body">
               <input type="hidden" name="id" value="{{ $subject->id }}">
                <div class="form-group">
                    <label for="exampleInputEmail1">Class name</label>
                    <input type="text" value="{{$subject->class_name}}" name="className" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Section name </label>
                    <input type="text" value="{{$subject->section_name}}" name="sectionName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Subject name </label>
                    <input type="text" value="{{$subject->subject_name}}" name="subjectName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Room </label>
                    <input type="text" value="{{$subject->room}}" name="room" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Description </label>
                    <textarea type="email" value="{{$subject->description}}" name="description" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"></textarea>
                </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary"  >Update Class</button>
        </div>
    </form>
      </div>
    </div>
  </div>
	<!-- end modal popup -->
