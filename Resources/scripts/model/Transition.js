Ext.provide('Phlexible.tasks.model.Transition');

Phlexible.tasks.model.Transition = Ext.data.Record.create([
    {name: 'id'},
    {name: 'name'},
    {name: 'old_state'},
    {name: 'new_state'},
    {name: 'create_user'},
    {name: 'created_at'}
]);
