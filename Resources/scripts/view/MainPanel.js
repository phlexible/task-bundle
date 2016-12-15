Ext.provide('Phlexible.tasks.ViewTemplate');
Ext.provide('Phlexible.tasks.CommentsTemplate');
Ext.provide('Phlexible.tasks.TransitionsTemplate');
Ext.provide('Phlexible.tasks.MainPanel');

Ext.require('Phlexible.tasks.FilterPanel');
Ext.require('Phlexible.tasks.TasksGrid');
Ext.require('Phlexible.tasks.AssignWindow');
Ext.require('Phlexible.tasks.CommentWindow');
Ext.require('Phlexible.tasks.TransitionWindow');

Phlexible.tasks.ViewTemplate = new Ext.XTemplate(
    '<div class="p-tasks-view">',
    '<table cellpadding="0" cellspacing="5">',
    '<colgroup>',
    '<col width="100" />',
    '<col width="240" />',
    '</colgroup>',
    '<tr>',
    '<th>{[Phlexible.tasks.Strings.task]}</th>',
    '<td>{title}</td>',
    '</tr>',
    '<tr>',
    '<th>{[Phlexible.tasks.Strings.task]}</th>',
    '<td>{text}</td>',
    '</tr>',
    '<tr>',
    '<th>{[Phlexible.tasks.Strings.status]}</th>',
    '<td>{[Phlexible.inlineIcon(\"p-task-status_\"+values.status+\"-icon\")]} {[Phlexible.tasks.Strings.get(values.status)]}</td>',
    '</tr>',
    '<tr>',
    '<th>{[Phlexible.tasks.Strings.description]}</th>',
    '<td>{description}</td>',
    '</tr>',
    '<tr>',
    '<th>{[Phlexible.tasks.Strings.assigned_to]}</th>',
    '<td>{assigned_user}<tpl if="values.assigned_user_id!==Phlexible.User.id"> (<a class="assign-to-me" href="#">{[Phlexible.tasks.Strings.assign_to_me]}</a>)</tpl></td>',
    '</tr>',
    '<tr>',
    '<th>{[Phlexible.tasks.Strings.create_user]}</th>',
    '<td>{create_user}</td>',
    '</tr>',
    '<tr>',
    '<th>{[Phlexible.tasks.Strings.created_at]}</th>',
    '<td>{created_at}</td>',
    '</tr>',
    '</table>',
    '</div>'
);

Phlexible.tasks.CommentsTemplate = new Ext.XTemplate(
    '<div class="p-tasks-comments">',
    '<tpl for=".">',
    '<div class="p-tasks-comment">',
    '<div class="p-tasks-by">{create_user} hat einen Kommentar hinzugefügt - {created_at}</div>',
    '<div class="p-tasks-text">{comment}</div>',
    '</div>',
    '</tpl>',
    '</div>'
);

Phlexible.tasks.TransitionsTemplate = new Ext.XTemplate(
    '<div class="p-tasks-transitions">',
    '<tpl for=".">',
    '<div class="p-tasks-transition">',
    '<div class="p-tasks-by">{create_user} änderte - {created_at}</div>',
    '<div class="p-tasks-text">' +
    '<div style="float: left;">{[Phlexible.inlineIcon(\"p-task-status_\" + values.old_state + \"-icon\")]} {old_state}</div>' +
    '<div style="margin-left: 120px;">{[Phlexible.inlineIcon(\"p-task-goto-icon\")]} ' +
    '{[Phlexible.inlineIcon(\"p-task-status_\" + values.new_state + \"-icon\")]} {new_state}</div>' +
    '<div style="clear: left; "></div>' +
    '</div>',
    '</div>',
    '</tpl>',
    '</div>'
);

Phlexible.tasks.MainPanel = Ext.extend(Ext.Panel, {
    title: Phlexible.tasks.Strings.tasks,
    strings: Phlexible.tasks.Strings,
    cls: 'p-tasks-main-panel',
    iconCls: 'p-task-component-icon',
    layout: 'border',
    border: false,

    params: {},

    loadParams: function (params) {
        if (params.id) {
            this.getComponent(1).getComponent(0).taskId = params.id;
            this.getComponent(0).onReset();
            this.getComponent(0).updateFilter();
        }
    },

    initComponent: function () {
        this.items = [
            {
                xtype: 'tasks-filterpanel',
                region: 'west',
                width: 200,
                collapsible: true,
                listeners: {
                    updateFilter: function (values) {
                        this.getComponent(1).getComponent(0).getStore().baseParams = values;
                        this.getComponent(1).getComponent(0).getStore().reload();
                    },
                    scope: this
                }
            },
            {
                xtype: 'panel',
                region: 'center',
                layout: 'border',
                border: false,
                items: [{
                    xtype: 'tasks-tasksgrid',
                    region: 'center',
                    taskId: this.params.id || false,
                    listeners: {
                        taskchange: this.onTaskChange,
                        scope: this
                    }
                },{
                    region: 'east',
                    layout: 'border',
                    width: 400,
                    border: false,
                    disabled: true,
                    items: [{
                        region: 'north',
                        height: 230,
                        html: '&nbsp;',
                        tbar: [{
                            text: this.strings.comment,
                            iconCls: 'p-task-comment_add-icon',
                            disabled: true,
                            handler: function() {
                                var win = new Phlexible.tasks.CommentWindow({
                                    task: this.getTaskGrid().getSelectionModel().getSelected(),
                                    listeners: {
                                        comment: this.onTaskChange,
                                        scope: this
                                    }
                                });
                                win.show();
                            },
                            scope: this
                        },{
                            text: this.strings.assign,
                            iconCls: 'p-task-assign-icon',
                            disabled: true,
                            handler: function() {
                                var win = new Phlexible.tasks.AssignWindow({
                                    task: this.getTaskGrid().getSelectionModel().getSelected(),
                                    listeners: {
                                        assign: this.onTaskChange,
                                        scope: this
                                    }
                                });
                                win.show();
                            },
                            scope: this
                        },'-'],
                        listeners: {
                            render: function(c) {
                                c.getEl().on('click', function(e) {
                                    e.stopEvent();
                                    var task = this.getTaskGrid().getSelectionModel().getSelected();
                                    Phlexible.tasks.util.TaskManager.assignToMe(task.id, function(success, result) {
                                        task.beginEdit();
                                        task.set('status', result.data.task.status);
                                        task.set('states', result.data.task.states);
                                        task.set('comments', result.data.task.comments);
                                        task.set('transitions', result.data.task.transitions);
                                        task.set('assigned_user', result.data.task.assigned_user);
                                        task.set('assigned_user_id', result.data.task.assigned_user_id);
                                        task.endEdit();
                                        task.commit();
                                        this.onTaskChange(task);
                                    }, this);
                                }, this, {delegate: 'a.assign-to-me'});
                            },
                            scope: this
                        }
                    },{
                        xtype: 'tabpanel',
                        region: 'center',
                        activeTab: 0,
                        deferredRender: false,
                        items: [{
                            title: this.strings.comments,
                            iconCls: 'p-task-comment-icon',
                            autoScroll: true,
                            html: '&nbsp;'
                        },{
                            title: this.strings.transitions,
                            iconCls: 'p-task-transition-icon',
                            autoScroll: true,
                            html: '&nbsp;'
                        }]
                    }]
                }]
            }
        ];

        Phlexible.tasks.MainPanel.superclass.initComponent.call(this);
    },

    getFilterPanel: function() {
        return this.getComponent(0);
    },

    getTaskGrid: function() {
        return this.getComponent(1).getComponent(0);
    },

    getTaskWrap: function() {
        return this.getComponent(1).getComponent(1);
    },

    getTaskView: function() {
        return this.getTaskWrap().getComponent(0);
    },

    getCommentsView: function() {
        return this.getTaskWrap().getComponent(1).getComponent(0);
    },

    getTransitionsView: function() {
        return this.getTaskWrap().getComponent(1).getComponent(1);
    },

    onTaskChange: function(task) {
        var taskView = this.getTaskView(),
            toolbar = taskView.getTopToolbar();

        Phlexible.tasks.ViewTemplate.overwrite(taskView.body, task.data);
        toolbar.items.each(function(item) {
            if (item.isStatus) {
                item.destroy();
            }
        });
        Ext.each(task.get('states'), function(state) {
            toolbar.add({
                text: state,
                isStatus: true,
                iconCls: 'p-task-transition_' + state + '-icon',
                handler: function() {
                    var w = new Phlexible.tasks.TransitionWindow({
                        title: state,
                        iconCls: 'p-task-transition_' + state + '-icon',
                        task: this.getTaskGrid().getSelectionModel().getSelected(),
                        newStatus: state,
                        listeners: {
                            transition: function() {
                                this.onTaskChange(task);
                            },
                            scope: this
                        }
                    });
                    w.show();
                },
                scope: this
            });
        }, this);

        toolbar.items.items[0].enable();
        toolbar.items.items[1].enable();

        Phlexible.tasks.CommentsTemplate.overwrite(this.getCommentsView().body, task.get('comments'));
        Phlexible.tasks.TransitionsTemplate.overwrite(this.getTransitionsView().body, task.get('transitions'));

        this.getTaskWrap().enable();
    }
});

Ext.reg('tasks-mainpanel', Phlexible.tasks.MainPanel);
