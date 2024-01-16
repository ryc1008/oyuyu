<template>
    <el-tiptap :content="content" @onUpdate="onEditorUpdate" lang="zh" :extensions="extensions" :height="height" placeholder="请输入内容"></el-tiptap>
</template>

<script>
//此编辑器有个BUG，打包后会报Duplicate use of selection JSON ID cell at Selection.jsonID的错误
//原因：引入了不同版本的模块prosemirror-tables
//解决1：找到tiptap-extensions依赖，删除node-modules/prosemirror-tables目录
//解决2：找到tiptap-extensions依赖，修改node-modules/prosemirror-tables目录为node-modules-
import { ElementTiptap,
    Doc,
    Text,
    Paragraph,
    Heading,
    Bold,
    Italic,
    Strike,
    Underline,
    Link,
    Image,
    Iframe,
    CodeBlock,
    Blockquote,
    ListItem,
    BulletList,
    OrderedList,
    TodoItem,
    TodoList,
    TextAlign,
    Indent,
    LineHeight,
    HorizontalRule,
    HardBreak,
    TrailingNode,
    History,
    Table ,
    TableHeader,
    TableCell,
    TableRow,
    FormatClear,
    TextColor,
    TextHighlight,
    Preview,
    Print,
    Fullscreen,
    SelectAll,
    FontType,
    FontSize,
    CodeView,
} from 'element-tiptap';
import 'element-tiptap/lib/index.css';
import {UploadImage} from "../../../utils/request.js";
export default {
    name: "editor",
    components: {'el-tiptap': ElementTiptap},
    model: {
        prop: 'content',
        event: 'input',
    },
    props: {
        content: {
            type: String,
            value: ''
        },
        height: {
            type: Number,
            value: 550
        }
    },
    data: function (){
        return {
            extensions: [
                new Doc(),
                new Text(),
                new Paragraph(),
                new Heading({ level: 5 }),
                new Bold({ bubble: true }),
                new Italic(),
                new Strike(),
                new Underline(),
                new Link(),
                new Image({
                    // 默认会把图片生成 base64 字符串和内容存储在一起，如果需要自定义图片上传
                    uploadRequest(file) {
                        // 如果接口要求 Content-Type 是 multipart/form-data，则请求体必须使用 FormData
                        const fd = new FormData()
                        fd.append('image', file)
                        // 第1个 return 是返回 Promise 对象
                        // 为什么？因为 axios 本身就是返回 Promise 对象
                        return UploadImage(fd).then(res => {
                            // 这个 return 是返回最后的结果
                            return res.data
                        })
                    } // 图片的上传方法，返回一个 Promise<url>
                }),
                // new Iframe(),
                new CodeBlock(),
                new Blockquote(),
                new ListItem(),
                new BulletList(),
                new OrderedList(),
                new TodoItem(),
                new TodoList(),
                new TextAlign(),
                new Indent(),
                new LineHeight(),
                new HorizontalRule(),
                new HardBreak(),
                new TrailingNode(),
                // new History(),
                new Table(),
                new TableHeader(),
                new TableCell(),
                new TableRow(),
                new FormatClear(),
                new TextColor(),
                new TextHighlight(),
                new Preview(),
                // new Print(),
                // new Fullscreen(),
                // new SelectAll(),
                new FontType(),
                new FontSize(),
                // new CodeView(),
            ],
        }
    },
    methods: {
        onEditorUpdate($event){
            this.$emit('input', $event)
        }
    }
}
</script>

<style scoped>

</style>
