Ext.provide('Phlexible.tasks.model.Comment');

Phlexible.tasks.model.Comment = Ext.data.Record.create([
    {name: 'id'},
    {name: 'current_state'},
    {name: 'comment'},
    {name: 'create_user'},
    {name: 'created_at'}
]);
