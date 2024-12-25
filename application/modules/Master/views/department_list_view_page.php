<section id="content-wrapper">

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <span class="h5">View Department Name Type</span>
                    <a class="float-end btn btn-blue btn-sm" href="department-master">Department Name Type
                        Master</a>
                </div>
                <div class="card-body">
                    <table class="table table-condensed table-bordered table-hover">
                        <thead class="table-success">
                            <tr>
                                <th>Supplier Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($department_name[0])) {
                                foreach ($department_name[0] as $user) { ?>
                                    <tr>
                                        <td><?= $user['RECORD_NAME']; ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-blue btn-sm">Action</button>
                                                <button type="button" class="btn btn-blue dropdown-toggle btn-sm"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu" style="right: 0;left: auto;">
                                                    <li>
                                                        <a class="btn btn-sm" onclick="editRow(this)"><i
                                                                class="fa fa-edit"></i>&nbsp;Edit</a>
                                                    </li>
                                                    <li>
                                                        <a class="btn btn-sm" onclick="deleteRow(this)"><i
                                                                class="fa fa-trash"></i>&nbsp;Delete</a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>