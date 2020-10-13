<?php
namespace backend\controllers;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;
use common\models\Category;
use common\models\Article;

use common\models\UploadForm;
use common\helper\Excel;
use yii\web\UploadedFile;


class CategoryController extends CommonController
{

    public function actionIndex()
    {

        $cate = Category::find()->orderBy('cate_order asc')->all();
        $list = Category::wuxianji($cate, $fid = 0, $level = 0);


        return $this->renderPartial('index', ['list' => $list]);
    }

    public function actionCreate()
    {
        $cate = Category::find()->orderBy('cate_order asc')->all();
        $list = Category::wuxianji($cate, $fid = 0, $level = 0);

        return $this->renderPartial('create', ['list' => $list]);
    }

    public function actionStore()
    {
        $cate_name = Yii::$app->request->post('cate_name');
        $cate_pid = Yii::$app->request->post('cate_pid');
        $cate_title = Yii::$app->request->post('cate_title');
        $cate_type = Yii::$app->request->post('cate_type');
        $cate_order = Yii::$app->request->post('cate_order');
        $category = Category::find();
        $category->where(['cate_name' => $cate_name]);
        $category->andWhere(['or', ['=', 'cate_pid', $cate_pid], ['=', 'cate_pid', '0']]);
        $result = $category->asArray()->one();

        if ($result) {
            $data = array(
                'status' => 2,
                'message' => '添加失败，分类名已存在'
            );
            return \yii\helpers\Json::encode($data);

        }
        $category = new Category;
        $category->cate_name = $cate_name;
        $category->cate_pid = $cate_pid;
        $category->cate_title = $cate_title;
        $category->cate_type = $cate_type;
        $category->cate_order = $cate_order;
        $res = $category->save();

        if ($res) {
            $data = array(
                'status' => 0,
                'message' => '添加成功'
            );
        } else {
            $data = array(
                'status' => 1,
                'message' => '添加失败'
            );
        }
        return \yii\helpers\Json::encode($data);
    }

    public function actionEdit($id)
    {
        $data = Category::findOne(['id' => $id]);
        $cate = Category::find()->orderBy('cate_order asc')->all();
        $list = Category::wuxianji($cate, $fid = 0, $level = 0);

        return $this->renderPartial('edit', ['list' => $list, 'data' => $data]);
    }

    public function actionUpdate()
    {
        $cate_name = Yii::$app->request->post('cate_name');
        $cate_pid = Yii::$app->request->post('cate_pid');
        $cate_title = Yii::$app->request->post('cate_title');
        $cate_type = Yii::$app->request->post('cate_type');
        $cate_order = Yii::$app->request->post('cate_order');
        $id = Yii::$app->request->post('id');

        $data1 = Category::findOne(['id' => $id]);

        $old_cate_pid = $data1->cate_pid;
        if ($old_cate_pid == 0) {
            if ($cate_pid != 0) {
                $data = array(
                    'status' => 3,
                    'message' => '修改失败，顶级栏目层级不可改变'
                );
                return \yii\helpers\Json::encode($data);
            }
        }

        $category = Category::find();
        $category->where(['!=', 'id', $id]);
        $category->andWhere(['cate_name' => $cate_name]);
        $category->andWhere(['or', ['=', 'cate_pid', $cate_pid], ['=', 'cate_pid', '0']]);
        $result = $category->asArray()->one();

        if ($result) {
            $data = array(
                'status' => 2,
                'message' => '修改失败，分类名已存在'
            );
            return \yii\helpers\Json::encode($data);

        }
        $res = Category::updateAll([
            'cate_name' => $cate_name,
            'cate_title' => $cate_title,
            'cate_order' => $cate_order,
            'cate_pid' => $cate_pid,
            'cate_type' => $cate_type,
        ], ['id' => $id]);

        if ($res) {
            $data = array(
                'status' => 0,
                'message' => '修改成功'
            );
        } else {
            $data = array(
                'status' => 1,
                'message' => '修改失败或没有修改'
            );
        }
        return \yii\helpers\Json::encode($data);
    }

    public function actionDestroy()
    {
        $id = Yii::$app->request->post('id');
        $data1 = Category::findOne(['id' => $id]);
        if ($data1->cate_pid == 0) {
            $res = Category::find()
                ->where(['cate_pid' => $id])
                ->count();

            if ($res != 0) {
                $data = array(
                    'status' => 3,
                    'message' => '删除失败，该栏目下存在子栏目'
                );
                return \yii\helpers\Json::encode($data);
            }
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $category = Category::find()->where(['id' => $id])->one();
            $art_id = $category->getArticle()->select('id')->column();
            $art_thumb = $category->getArticle()->select('art_thumb')->column();
            $art_thumball = $category->getArticle()->select('thumball')->column();
            $category->delete();
            if (count($art_id) != 0) {
                Article::deleteAll(['id' => $art_id]);
                foreach ($art_thumb as $key => $val) {
                    if ($val != '') {
                        if (file_exists(\Yii::$app->getBasePath() . '/web/' . $val)) {
                            unlink(\Yii::$app->getBasePath() . '/web/' . $val);
                        }
                    }
                }
                foreach ($art_thumball as $key => $val) {
                    if ($val != '') {
                        $arr = explode(',', $val);
                        foreach ($arr as $k => $v) {
                            if (file_exists(\Yii::$app->getBasePath() . '/web/' . $v)) {
                                unlink(\Yii::$app->getBasePath() . '/web/' . $v);
                            }
                        }

                    }
                }
            }

            $transaction->commit();

            $data = array(
                'status' => 0,
                'message' => '删除成功'
            );
            return \yii\helpers\Json::encode($data);

        } catch (\Exception $e) {
            //操作回滚
            $transaction->rollBack();

            $data = array(
                'status' => 1,
                'message' => $e->getMessage()
            );
            return \yii\helpers\Json::encode($data);
        }

    }

    public function actionDelall()
    {
        $ids = Yii::$app->request->post('ids');
        $list = Category::find()
            ->where(['id' => $ids])
            ->asArray()//转数组
            ->all();    //查询全部
        foreach ($list as $key => $val) {
            $res = Category::find()->where(['cate_pid' => $val['id']])->count();
            if ($res != 0) {
                $data = array(
                    'status' => 3,
                    'message' => '删除失败，要删除的栏目下存在子栏目'
                );
                return \yii\helpers\Json::encode($data);
            }
        }


        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($ids as $ke => $va) {
                $category = Category::find()->where(['id' => $va])->one();
                $art_id = $category->getArticle()->select('id')->column();
                $art_thumb = $category->getArticle()->select('art_thumb')->column();
                $art_thumball = $category->getArticle()->select('thumball')->column();
                if (count($art_id) != 0) {
                    Article::deleteAll(['id' => $art_id]);
                    foreach ($art_thumb as $key => $val) {
                        if ($val != '') {
                            if (file_exists(\Yii::$app->getBasePath() . '/web/' . $val)) {
                                unlink(\Yii::$app->getBasePath() . '/web/' . $val);
                            }
                        }
                    }
                    foreach ($art_thumball as $key => $val) {
                        if ($val != '') {
                            $arr = explode(',', $val);
                            foreach ($arr as $k => $v) {
                                if (file_exists(\Yii::$app->getBasePath() . '/web/' . $v)) {
                                    unlink(\Yii::$app->getBasePath() . '/web/' . $v);
                                }
                            }
                        }
                    }
                }

            }
            Category::deleteAll(['id' => $ids]);

            $transaction->commit();

            $data = array(
                'status' => 0,
                'message' => '删除成功'
            );
            return \yii\helpers\Json::encode($data);

        } catch (\Exception $e) {
            //操作回滚
            $transaction->rollBack();

            $data = array(
                'status' => 1,
                'message' => $e->getMessage()
            );
            return \yii\helpers\Json::encode($data);
        }

    }

    public function actionPaixu()
    {

        $id = Yii::$app->request->post('id');
        $cate_order = Yii::$app->request->post('cate_order');
        $res = Category::updateAll(['cate_order' => $cate_order], ['id' => $id]);

        if ($res) {
            $data = array(
                'status' => 0,
                'message' => '修改成功'
            );
        } else {
            $data = array(
                'status' => 1,
                'message' => '排序修改失败'
            );
        }

        return \yii\helpers\Json::encode($data);
    }

    // csv导出百万级数据，
    public function actionExpuser1()
    {
        set_time_limit(0);
        $arrData = array();
        for ($i = 0; $i <= 79; $i++) {
            $db = (new \yii\db\Query());
            $list = $db->from('qw_qikan')->limit(10000)->offset($i * 10000)->all();

            foreach ($list as $key => $val) {
                $arrData[] = [
                    'id' => $val['id'],
                    'name' => $val['name'],
                    'shengri' => $val['shengri'],
                    'keyword' => $val['keyword'],
                    'zhiwu' => $val['zhiwu'],
                ];
            }

        }

        $title = [
            [
                'ID',
                '姓名',
                '生日',
                '关键字',
                '职务',
            ],
        ];
        $arrData = array_merge($title, $arrData);

        header('Content-Description: File Transfer');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=test.csv');
        header('Cache-Control: max-age=0');


        $fp = fopen('php://output', 'a');//打开output流


        $dataNum = count($arrData);
        $perSize = 1000;//每次导出的条数
        $pages = ceil($dataNum / $perSize);

        for ($i = 0; $i <= $pages - 1; $i++) {
            foreach (array_slice($arrData, $i * 1000, 1000) as $item) {
                mb_convert_variables('GBK', 'UTF-8', $item);
                fputcsv($fp, $item);
            }
            //刷新输出缓冲到浏览器
            ob_flush();
            flush();//必须同时使用 ob_flush() 和flush() 函数来刷新输出缓冲。
        }
        fclose($fp);
        exit();


    }
    //正常导出
    function actionExpuser()
    {//导出Excel

        $xlsName = "客户信息表";
        $xlsCell = array(
            '用户名',
            '头衔',
            '国家',
            '电子邮件',
            '机构',
            '邮箱',
        );
        $db = (new \yii\db\Query());
        $xlsData = $db->from('qw_qikan')->select('id,name,shengri,keyword,zhiwu,email')->limit(10000)->all();

        Excel::exportExcel($xlsData, $xlsCell,$xlsName);
//        $this->tofile($xlsCell, $xlsData, $xlsName);
    }
    // 导入表格
    public function actionImport_excel_data()
    {
        $model = new UploadForm();
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file && $model->validate()) {
                $path = 'uploads/';
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                $time = time();
                $rand = rand(100, 999);
                $basename = $model->file->baseName;
                $filename = md5($basename . $time . $rand);
                $fname = $path . $filename . '.' . $model->file->extension;
                if ($model->file && $model->validate()) {
                    $model->file->saveAs($fname);
                }
                $fpath = Yii::$app->BasePath . '/web/' . $fname;

                $data = Excel::importExecl($fpath);
                # 得到表头
                $biaotou = $data[1];

                $count = count($data);
//                var_dump($data);
//                exit;
//                if ($biaotou['A'] != '日期' || $biaotou['B'] != '损坏产品名称' || $biaotou['C'] != '产品使用人'
//                    || $biaotou['D'] != '产品所属部门' || $biaotou['E'] != '损坏原因') {
//                    return "表格表头不匹配";
//                }
                # 这里要从第二行开始读 因为第一行是表头
                # 拿到数据后写入数据里面 建议这里用批量写入的方式而不是再循环里面写入数据库
                for ($i = 2; $i < $count + 1; $i++) {
                    $data['m_mail'] =$data[$i]['F'];


//                    echo '日期' . $data[$i]['A'] . "</br>";
//                    echo '损坏产品名称' . $data[$i]['B'] . "</br>";
//                    echo '产品使用人' . $data[$i]['C'] . "</br>";
//                    echo '产品所属部门' . $data[$i]['D'] . "</br>";
//                    echo '损坏原因' . $data[$i]['E'] . "</br>";
                }
//处理结果成功或失败
                Yii::$app->session->setFlash('success','导入成功');
//                Yii::$app->session->setFlash('error','导入失败');
                return $this->redirect(['index']);
            }
        }


    }

    //csv文件导入
    public function actionPiliang(){

        $filename = $_FILES['file']['tmp_name'];
        $name=$_FILES['file']['name'];

        if (empty ($filename)) {
            echo '请选择要导入的CSV文件！';
            exit;
        }
        $handle = fopen($filename, 'r');
        $result = $this->input_csv($handle); //解析csv
        $len_result = count($result);
        if($len_result==0){
            echo '没有任何数据！';
            exit;
        }
        $wan=0;
//        $db2=Db::connect('db_config1');
        $data_values=array();
        for ($i = 1; $i < $len_result; $i++) { //循环获取各字段值
            $data_values[]= array(
                'id'=>iconv('gb2312', 'utf-8', $result[$i][0]),
                'name'=>iconv('gb2312', 'utf-8', $result[$i][1]),
                'shengri'=>iconv('gb2312', 'utf-8', $result[$i][2]),
                'gjz'=>iconv('gb2312', 'utf-8', $result[$i][3]),
                'zhiwu'=>iconv('gb2312', 'utf-8', $result[$i][4]),

            );

//            $query= $db2->name('csv')->insert($data_values);
//            if(!$query){
//                $wan=1;
//                echo '导入失败！';
//            }
        }
        dd($data_values);
        fclose($handle); //关闭指针

        if($wan==0){
            //处理结果成功或失败
//                Yii::$app->session->setFlash('success','导入成功');
//                Yii::$app->session->setFlash('error','导入失败');
            return $this->redirect(['index']);
        }
    }


    //csv文件导入转数组
    public function  input_csv($handle) {
        $out = array ();
        $n = 0;
        while ($data = fgetcsv($handle, 10000)) {
            $num = count($data);
            for ($i = 0; $i < $num; $i++) {
                $out[$n][$i] = $data[$i];
            }
            $n++;
        }
        return $out;
    }

}