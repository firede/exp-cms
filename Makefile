# 程序目录相对于整个站点的路径，用于生成调试代码地址
APP_PATH = /

ADMIN_DIR = assets/admin

# 管理端JS路径
ADMINJS_DIR = ${ADMIN_DIR}/js
ADMINJS_SRC_DIR = ${ADMINJS_DIR}/src

ADMINJS_FILES = ${ADMINJS_SRC_DIR}/dxn.js\
                ${ADMINJS_SRC_DIR}/util.js\
				${ADMINJS_SRC_DIR}/asideMenu.js\
                ${ADMINJS_SRC_DIR}/subView.js\
                ${ADMINJS_SRC_DIR}/dataTable.js\
                ${ADMINJS_SRC_DIR}/mutiOperation.js\
                ${ADMINJS_SRC_DIR}/tableSearch.js\
				${ADMINJS_SRC_DIR}/plugins/cateSelector.js\
				${ADMINJS_SRC_DIR}/cateAdmin.js

ADMINJS_OUTPUT = ${ADMINJS_DIR}/admin.js


# 管理CSS路径
ADMINCSS_DIR = ${ADMIN_DIR}

ADMINCSS_FILES = ${ADMINCSS_DIR}/main.css

ADMINCSS_OUTPUT = ${ADMINCSS_DIR}/admin.css


# 我使用的是基于nodeJS的nodelint
JSLINT = nodelint
# 使用yui-compressor来压缩CSS
YUI = yuicompressor
# 使用Google closure compiler来压缩JS
CLOSURE = closure


# 默认任务，将依次进行语法检查、合并、压缩
all: lint compress
		@@echo ""
		@@echo "\033[49;32;1mCongratulations!\033[0m"

# 检查任务组 lint
lint: adminjs_lint
		@@echo "\033[49;33;1mLINT SUCCESS!\033[0m"


# 压缩任务组
compress: adminjs_compress admincss_compress
		@@echo "\033[49;33;1mCOMPRESS SUCCESS!\033[0m"

# 调试模式任务组
debug: adminjs_debug admincss_debug
		@@echo "\033[49;33;1mDEBUG SUCCESS!\033[0m"


# 管理端JS任务
adminjs_lint:
		@@${JSLINT} ${ADMINJS_FILES}
		@@echo "AdminJS -> lint: success"

adminjs_concat:
		@@cat ${ADMINJS_FILES} > ${ADMINJS_OUTPUT}
		@@echo "AdminJS -> concat: success"

adminjs_compress: adminjs_concat
		@@${CLOSURE} --js ${ADMINJS_OUTPUT} --warning_level QUIET --js_output_file ${ADMINJS_OUTPUT}.tmp
		@@mv ${ADMINJS_OUTPUT}.tmp ${ADMINJS_OUTPUT}
		@@echo "AdminJS -> compress: success"

adminjs_debug:
		@@rm -f ${ADMINJS_OUTPUT}
		@@for i in ${ADMINJS_FILES}; \
			do echo "document.write(\"<script src='${APP_PATH}$$i' type='text/javascript'></script>\");" >> ${ADMINJS_OUTPUT}; \
			done;
		@@echo "AdminJS -> debug: success"


admincss_concat:
		@@cat ${ADMINCSS_FILES} > ${ADMINCSS_OUTPUT}
		@@echo "AdminCSS -> concat: success"

admincss_compress: admincss_concat
		@@${YUI} --type css --charset utf-8 -o ${ADMINCSS_OUTPUT}.tmp ${ADMINCSS_OUTPUT}
		@@mv ${ADMINCSS_OUTPUT}.tmp ${ADMINCSS_OUTPUT}
		@@echo "AdminCSS -> compress: success"

admincss_debug:
		@@rm -f ${ADMINCSS_OUTPUT}
		@@for i in ${ADMINCSS_FILES}; \
			do echo "@import url('${APP_PATH}$$i');" >> ${ADMINCSS_OUTPUT}; \
			done;
		@@echo "AdminCSS -> debug: success"
