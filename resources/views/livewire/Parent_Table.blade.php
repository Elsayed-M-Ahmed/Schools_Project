<button class="btn btn-success btn-sm btn-lg pull-right" wire:click="show_add_form" type="button">{{ trans('Parent_trans.add_parent') }}</button><br><br>
<div class="table-responsive">
    <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
           style="text-align: center">
        <thead>
        <tr class="table-success">
            <th>#</th>
            <th>{{ trans('Parent_trans.Email') }}</th>
            <th>{{ trans('Parent_trans.Name_Father') }}</th>
            <th>{{ trans('Parent_trans.National_ID_Father') }}</th>
            <th>{{ trans('Parent_trans.Passport_ID_Father') }}</th>
            <th>{{ trans('Parent_trans.Phone_Father') }}</th>
            <th>{{ trans('Parent_trans.Job_Father') }}</th>
            <th>{{ trans('Parent_trans.Processes') }}</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 0; ?>
        @foreach ($Parents as $Parent)
            <tr>
                <?php $i++; ?>
                <td>{{ $i }}</td>
                <td>{{ $Parent->Email }}</td>
                <td>{{ $Parent->Name_Father }}</td>
                <td>{{ $Parent->National_ID_Father }}</td>
                <td>{{ $Parent->Passport_ID_Father }}</td>
                <td>{{ $Parent->Phone_Father }}</td>
                <td>{{ $Parent->Job_Father }}</td>
                <td>
                    <button wire:click="edit({{ $Parent->id }})" title="{{ trans('Grades_trans.Edit') }}"
                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>

                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#delete{{ $Parent->id }}"
                                                title="{{ trans('Parents_trans.Delete') }}"><i
                                                class="fa fa-trash"></i></button>
                    
                </td>
            </tr>

            <!-- delete_modal_Parent -->
            <div class="modal fade" id="delete{{ $Parent->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog" role="document">
                   <div class="modal-content">
                       <div class="modal-header">
                           <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                               id="exampleModalLabel">
                               {{ trans('Parent_trans.delete_parent') }}
                           </h5>
                           <button type="button" class="close" data-dismiss="modal"
                                   aria-label="Close">
                               <span aria-hidden="true">&times;</span>
                           </button>
                       </div>
                       <div class="modal-body">
                           <form action="" method="post">
                               {{method_field('Delete')}}
                               @csrf
                               {{ trans('Grades_trans.Warning_Grade') }}
                               <input id="id" type="hidden" name="id" class="form-control"
                                      value="{{ $Parent->id }}">
                               <div class="modal-footer">
                                   <button type="button" class="btn btn-secondary"
                                           data-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                                           <button type="button" class="btn btn-danger btn-sm" wire:click="delete({{ $Parent->id }})" title="{{ trans('Grades_trans.Delete') }}"><i class="fa fa-trash"></i></button>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
           </div>
           {{-- end delete model --}}
        @endforeach
    </table>
</div>
