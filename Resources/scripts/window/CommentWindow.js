Ext.provide('Phlexible.tasks.CommentWindow');

Ext.require('Phlexible.tasks.util.TaskManager');

Phlexible.tasks.CommentWindow = Ext.extend(Ext.Window, {
    title: Phlexible.tasks.Strings.comment,
    strings: Phlexible.tasks.Strings,
    width: 400,
    minWidth: 400,
    height: 270,
    minHeight: 270,
    layout: 'fit',
    modal: true,

    payload: {},
    component_filter: null,

    initComponent: function () {

        this.items = [
            {
                xtype: 'form',
                border: false,
                bodyStyle: 'padding: 5px',
                monitorValid: true,
                items: [
                    {
                        xtype: 'textarea',
                        anchor: '100%',
                        height: 140,
                        allowBlank: false,
                        hideLabel: true,
                        name: 'comment'
                    }
                ],
                bindHandler: function () {
                    var valid = true;
                    this.form.items.each(function (f) {
                        if (!f.isValid(true)) {
                            valid = false;
                            return false;
                        }
                    });
                    if (this.ownerCt.buttons) {
                        for (var i = 0, len = this.ownerCt.buttons.length; i < len; i++) {
                            var btn = this.ownerCt.buttons[i];
                            if (btn.formBind === true && btn.disabled === valid) {
                                btn.setDisabled(!valid);
                            }
                        }
                    }
                    this.fireEvent('clientvalidation', this, valid);
                }
            }
        ];

        this.buttons = [
            {
                text: this.strings.cancel,
                handler: this.close,
                scope: this
            },
            {
                text: this.strings.comment,
                handler: this.comment,
                formBind: true,
                scope: this
            }
        ];

        Phlexible.tasks.CommentWindow.superclass.initComponent.call(this);
    },

    comment: function () {
        if (!this.getComponent(0).form.isValid()) {
            return;
        }

        var values = this.getComponent(0).getForm().getValues(),
            self = this;

        Phlexible.tasks.util.TaskManager.comment(this.task.id, values.comment, function(success, result) {
            if (success && result.success) {
                self.task.data.status = result.data.task.status;
                self.task.data.states = result.data.task.states;
                self.task.data.comments = result.data.task.comments;
                self.task.data.transitions = result.data.task.transitions;
                self.task.data.assigned_user = result.data.task.assigned_user;

                self.fireEvent('comment', self.task);
                self.close();
            }
        });
    }
});
