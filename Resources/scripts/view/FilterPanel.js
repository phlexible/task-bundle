Ext.provide('Phlexible.tasks.FilterPanel');

Phlexible.tasks.FilterPanel = Ext.extend(Ext.form.FormPanel, {
    title: Phlexible.tasks.Strings.filter,
    strings: Phlexible.tasks.Strings,
    bodyStyle: 'padding: 5px;',
    cls: 'p-tasks-filter-panel',
    iconCls: 'p-task-filter-icon',
    autoScroll: true,

    initComponent: function () {
        this.task = new Ext.util.DelayedTask(this.updateFilter, this);

        this.items = [
            {
                xtype: 'panel',
                title: this.strings.comments,
                layout: 'form',
                frame: true,
                collapsible: true,
                labelAlign: 'top',
                hidden: true,
                items: [
                    {
                        xtype: 'textfield',
                        hideLabel: true,
                        anchor: '-25',
                        name: 'comments',
                        labelAlign: 'top',
                        enableKeyEvents: true,
                        listeners: {
                            keyup: function (field, event) {
                                if (event.getKey() == event.ENTER) {
                                    this.task.cancel();
                                    this.updateFilter();
                                    return;
                                }

                                this.task.delay(500);
                            },
                            scope: this
                        }
                    }
                ]
            },
            {
                xtype: 'panel',
                title: this.strings.tasks,
                layout: 'form',
                frame: true,
                collapsible: true,
                defaults: {
                    hideLabel: true
                },
                items: [
                    {
                        xtype: 'radio',
                        name: 'tasks',
                        boxLabel: this.strings.assigned_to_me,
                        inputValue: 'todos',
                        listeners: {
                            check: function (cb, checked) {
                                if (checked) {
                                    this.updateFilter();
                                }
                            },
                            scope: this
                        }
                    },
                    {
                        xtype: 'radio',
                        name: 'tasks',
                        boxLabel: this.strings.created_by_me,
                        inputValue: 'tasks',
                        listeners: {
                            check: function (cb, checked) {
                                if (checked) {
                                    this.updateFilter();
                                }
                            },
                            scope: this
                        }
                    },
                    {
                        xtype: 'radio',
                        name: 'tasks',
                        boxLabel: this.strings.involved,
                        inputValue: 'involved',
                        checked: true,
                        listeners: {
                            check: function (cb, checked) {
                                if (checked) {
                                    this.updateFilter();
                                }
                            },
                            scope: this
                        }
                    },
                    {
                        xtype: 'radio',
                        name: 'tasks',
                        boxLabel: this.strings.all_tasks,
                        inputValue: 'all',
                        listeners: {
                            check: function (cb, checked) {
                                if (checked) {
                                    this.updateFilter();
                                }
                            },
                            scope: this
                        }
                    }
                ]
            },
            {
                xtype: 'panel',
                title: this.strings.status,
                layout: 'form',
                frame: true,
                collapsible: true,
                autoHeight: true,
                defaults: {
                    hideLabel: true
                },
                items: []
            }
        ];

        Ext.Ajax.request({
            url: Phlexible.Router.generate('tasks_states'),
            success: function(response) {
                var result = Ext.decode(response.responseText),
                    p = this.getComponent(2),
                    values = {
                        tasks: 'involved'
                    };

                Ext.each(result.states, function(state) {
                    p.add({
                        xtype: 'checkbox',
                        name: 'status_'+state.name,
                        boxLabel: Phlexible.inlineIcon('p-task-status_'+state.name+'-icon') + ' ' + this.strings[state.name],
                        checked: state.properties && state.properties.defaultVisible ? true : false,
                        listeners: {
                            check: this.updateFilter,
                            scope: this
                        }
                    });
                    if (state.properties.defaultVisible) {
                        values['status_' + state.name] = 1;
                    }
                }, this);

                p.doLayout();
                this.fireEvent('updateFilter', values);
            },
            scope: this
        });

        Phlexible.tasks.FilterPanel.superclass.initComponent.call(this);
    },

    onReset: function () {
        this.form.reset();
    },

    updateFilter: function () {
        var values = this.form.getValues();

        this.fireEvent('updateFilter', values);
    }
});

Ext.reg('tasks-filterpanel', Phlexible.tasks.FilterPanel);
