Ext.provide('Phlexible.tasks.model.Task');

Phlexible.tasks.model.Task = Ext.data.Record.create([
    {name: 'id'},
    {name: 'type'},
    {name: 'generic'},
    {name: 'name'},
    {name: 'summary'},
    {name: 'description'},
    {name: 'component'},
    {name: 'created'},
    {name: 'link'},
    {name: 'assigned_user'},
    {name: 'assigned_user_id'},
    {name: 'status'},
    {name: 'create_user'},
    {name: 'create_user_id'},
    {name: 'created_at'},
    {name: 'transitions'},
    {name: 'comments'},
    {name: 'states'}
]);
