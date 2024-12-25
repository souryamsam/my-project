<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <span class="h5">Item Category Master</span>
                    <a class="float-end btn btn-blue btn-sm" href="view-category-master.html"><i class="fa fa-list"></i> View Item
                        Category</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped" style="width: 100%;" id="dynamic_table">
                                    <thead class="table-success">
                                        <tr>
                                            <td style="width: 30%;" colspan="2">Item Type</td>
                                            <td style="width: 40%;">Item Category</td>
                                            <td style="width: 25%;">Item Sub-Category</td>
                                            <td style="width: 10%;">&nbsp;</td>
                                        </tr>
                                    </thead>
                                    <tbody id="dynamic_table_body">
                                        <tr>
                                            <td colspan="2">
                                                <select class="form-select select2 form-select-sm" id="category">
                                                    <option value="">Select</option>
                                                    <option value="Assets">Assets</option>
                                                    <option value="Comsumables">Comsumables</option>
                                                    <option value="Edible Items">Edible Items</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" id="subcategory" autocomplete="off">
                                            </td>

                                            <td>
                                                <input type="text" class="form-control form-control-sm" id="Quantity">
                                            </td>
                                            <td><button class="btn btn-blue btn-sm" onclick="addRow()"><i class="fa fa-plus"> </i></button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-end">
                        <a class="btn btn-success btn-sm" href="view-category-master.html"><i class="fa fa-save"></i>&nbsp;Save</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>