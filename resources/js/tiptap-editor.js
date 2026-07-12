import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import Image from '@tiptap/extension-image'
import Link from '@tiptap/extension-link'
import Placeholder from '@tiptap/extension-placeholder'
import Underline from '@tiptap/extension-underline'
import TextAlign from '@tiptap/extension-text-align'

document.addEventListener('alpine:init', () => {
    Alpine.data('tiptapEditor', (config = {}) => ({
        editor: null,

        init() {
            this.$nextTick(() => {
                this.startListening()
            })
        },

        startListening() {
            document.addEventListener('modal-show', (e) => {
                if (e.detail.name === config.modalName) {
                    this.$nextTick(() => this.bootEditor())
                }
            })

            document.removeEventListener('modal-close', this._handleClose)
            this._handleClose = (e) => {
                if (e.detail.name === config.modalName) {
                    this.tearDown()
                }
            }
            document.addEventListener('modal-close', this._handleClose)
        },

        bootEditor() {
            if (this.editor) this.tearDown()

            const el = this.$refs.editor
            if (!el) return

            this.editor = new Editor({
                element: el,
                extensions: [
                    StarterKit.configure({
                        heading: { levels: [1, 2, 3] },
                    }),
                    Underline,
                    TextAlign.configure({
                        types: ['heading', 'paragraph'],
                    }),
                    Image.configure({ inline: true }),
                    Link.configure({
                        openOnClick: false,
                        HTMLAttributes: { class: 'text-primary underline cursor-pointer' },
                    }),
                    Placeholder.configure({
                        placeholder: config.placeholder || 'Start writing...',
                    }),
                ],
                content: this.getContent(),
                onUpdate: ({ editor }) => {
                    if (this.$wire) {
                        this.$wire.set(config.model || 'form.content', editor.getHTML())
                    }
                },
            })
        },

        getContent() {
            if (this.$wire?.form?.content) return this.$wire.form.content
            return config.content || ''
        },

        tearDown() {
            if (this.editor) {
                this.editor.destroy()
                this.editor = null
            }
        },

        destroy() {
            this.tearDown()
            document.removeEventListener('modal-close', this._handleClose)
        },

        isActive(type, attrs) {
            return this.editor?.isActive(type, attrs) ?? false
        },
    }))
})
