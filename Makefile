# 程序目录相对于整个站点的路径，用于生成调试代码地址
APP_PATH = /

# 管理端JS路径
ADMINJS_DIR = assets/admin/js
ADMINJS_SRC_DIR = ${ADMINJS_DIR}/src

ADMINJS_FILES = ${ADMINJS_SRC_DIR}/dxn.js\
                ${ADMINJS_SRC_DIR}/util.js\
                ${ADMINJS_SRC_DIR}/subView.js\
                ${ADMINJS_SRC_DIR}/dataTable.js\
                ${ADMINJS_SRC_DIR}/mutiOperation.js\
                ${ADMINJS_SRC_DIR}/tableSearch.js

ADMINJS_OUTPUT = ${ADMINJS_DIR}/admin.js


# 我使用的是基于nodeJS的nodelint
JSLINT = nodelint
# 使用yui-compressor来压缩CSS
YUI = yuicompressor
# 使用Google closure compiler来压缩JS
CLOSURE = closure

# 默认任务，将依次进行语法检查、合并、压缩
all: adminjs_lint adminjs_concat adminjs_compress
		@@echo "恭喜你，全搞定啦！"

adminjs_lint:
		@@echo "===== 开始检查语法 ====="
		@@${JSLINT} ${ADMINJS_FILES}
		@@echo "检查完毕！"

adminjs_concat:
		@@echo "===== 开始合并文件 ====="
		@@cat ${ADMINJS_FILES} > ${ADMINJS_OUTPUT}
		@@echo "合并完毕！"

adminjs_compress: adminjs_concat
		@@echo "===== 开始压缩文件 ====="
		@@${CLOSURE} --js ${ADMINJS_OUTPUT} --warning_level QUIET --js_output_file ${ADMINJS_OUTPUT}.tmp
		@@mv ${ADMINJS_OUTPUT}.tmp ${ADMINJS_OUTPUT}
		@@echo "压缩完毕！"

adminjs_debug:
		@@echo "===== 开始恢复调试模式 ====="
		@@rm -r ${ADMINJS_OUTPUT}
		@@for i in ${ADMINJS_FILES}; \
			do echo "document.write(\"<script src='${APP_PATH}$$i' type='text/javascript'></script>\");" >> ${ADMINJS_OUTPUT}; \
			done;
		@@echo "恢复完毕！"