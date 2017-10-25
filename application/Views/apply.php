<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="initial-scale=1, maximum-scale=1">
  <!-- 引入样式 -->
  <link rel="stylesheet" href="<?php echo base_url()?>apply/css/index.css">
  <link rel="stylesheet" href="<?php echo base_url()?>apply/css/enter.css">
</head>
<body>
    <div id="app">
          <el-row>
              <el-col :span="1"><div class="grid-content radius-left title"></div></el-col>
              <el-col :span="22"><div class="grid-content bg-purple-light title">中德护士（护理）交流计划学员报名表</div></el-col>
              <el-col :span="1"><div class="grid-content radius-right title"></div></el-col>
          </el-row>
          <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="95px" class="demo-ruleForm">
              <el-form-item label="请上传照片" prop="photo">
                  <el-upload
                  v-model="ruleForm.photo"
                  class="avatar-uploader photo_div"
                  action="<?php echo base_url()?>apply_in/upload_img"
                  :show-file-list="false"
                  :on-success="handleAvatarSuccess"
                  :before-upload="beforeAvatarUpload">
                  <img v-if="imageUrl" :src="imageUrl" class="avatar">
                  <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                 </el-upload>
              </el-form-item>
              <el-form-item label="姓名" prop="c_name">
                  <el-input v-model="ruleForm.c_name" ref="c_name"></el-input>
              </el-form-item>
              <el-form-item label="拼音" prop="e_name">
                <el-input v-model="ruleForm.e_name" ref="e_name"></el-input>
              </el-form-item>
              <el-form-item label="性别" prop="radio" label-width="95px">
                <el-radio-group v-model="ruleForm.radio" ref="radio">
                  <el-radio label="1">男</el-radio>
                  <el-radio label="2">女</el-radio>
                </el-radio-group>
              </el-form-item>
              <el-form-item label="民族" prop="nation">
                 <el-input v-model="ruleForm.nation" ref="nation"></el-input>
              </el-form-item>
              <el-form-item label="身份证号码" prop="id">
                <el-input v-model="ruleForm.id" ref="id"></el-input>
              </el-form-item>
              <el-form-item label="出生日期" required>
                <el-col :span="24">
                  <el-form-item prop="date">
                    <el-date-picker type="date" placeholder="选择日期" v-model="ruleForm.date" style="width: 100%;" ref="date" :editable="false"></el-date-picker>
                  </el-form-item>
                </el-col>
              </el-form-item>
              <el-form :model="numberValidateForm" ref="numberValidateForm" label-width="95px" class="demo-ruleForm">
              <el-form-item label="电话号码" prop="phone" :rules="[{ required: true, message: '电话号码不能为空'},{ type: 'number', message: '电话号码必须为数字值'}]">
                <el-input type="phone" v-model.number="numberValidateForm.phone" auto-complete="off" ref="phone"></el-input>
              </el-form-item>
              </el-form>
              <el-form-item label="QQ" prop="qq">
              <el-input v-model="ruleForm.qq" ref="qq"></el-input>
              </el-form-item>
              <el-form :model="dynamicValidateForm" ref="dynamicValidateForm" label-width="95px" class="demo-dynamic">
              <el-form-item prop="email" label="邮箱" :rules="[{ required: true, message: '请输入邮箱地址', trigger: 'blur' },{ type: 'email', message: '请输入正确的邮箱地址', trigger: 'blur,change' }]">
                <el-input v-model="dynamicValidateForm.email" ref="email"></el-input>
              </el-form-item>
              </el-form>
              <el-form-item label="户籍所在地" prop="id_place">
                <el-input v-model="ruleForm.id_place" ref="id_place"></el-input>
              </el-form-item>
              <el-form-item label="家庭住址" prop="place">
                <el-input v-model="ruleForm.place" ref="place"></el-input>
              </el-form-item>
              <el-form-item label="地区" prop="area">
                <el-input v-model="ruleForm.area" ref="area"></el-input>
              </el-form-item>
              <el-form-item label="编号" prop="num">
                <el-input v-model="ruleForm.num" ref="num"></el-input>
              </el-form-item>
              <el-form-item label="婚姻状况" prop="is_married">
                <el-select v-model="ruleForm.is_married" placeholder="请选择" ref="is_married">
                  <el-option label="未婚" value="未婚"></el-option>
                  <el-option label="已婚" value="已婚"></el-option>
                </el-select>
              </el-form-item>
              <el-form-item label="健康状况" prop="is_health">
                <el-select v-model="ruleForm.is_health" placeholder="请选择" ref="is_health">
                  <el-option label="良好" value="良好"></el-option>
                  <el-option label="亚健康" value="亚健康"></el-option>
                </el-select>
              </el-form-item>
              <el-form-item label="德语等级" prop="german_grade">
                <el-select v-model="ruleForm.german_grade" placeholder="请选择" ref="german_grade">
                  <el-option label="A1" value="A1"></el-option>
                  <el-option label="A2" value="A2"></el-option>
                  <el-option label="B1" value="B1"></el-option>
                  <el-option label="B2" value="B2"></el-option>
                  <el-option label="C1" value="C1"></el-option>
                  <el-option label="C2" value="C2"></el-option>
                </el-select>
              </el-form-item>
              <el-form-item label="文化程度" prop="education">
                  <el-input v-model="ruleForm.education" ref="education"></el-input>
              </el-form-item>
              <el-form-item label="有无犯罪记录" prop="record" label-width="105px">
                <el-radio-group v-model="ruleForm.record" ref="record">
                  <div class="radio-wrap"><el-radio label="有" class="yes"></el-radio></div>
                  <div class="radio-wrap"><el-radio label="无" class="no"></el-radio></div>
                </el-radio-group>
              </el-form-item>
             <el-form-item label="主要简历" prop="resume" class="main_resume">
                      <el-row>
                          <el-col :span="24">
                            <div class="grid-content">
                              <div class="block">
                                <el-date-picker v-model="resume1" type="daterange" placeholder="选择日期范围" ref="date_section1" :editable="false"></el-date-picker>
                              </div>
                            </div>
                          </el-col>
                      </el-row>
                      <el-row>
                          <el-col :span="24">
                            <el-input type="textarea" placeholder="单位/学校名称、职位/专业、工作/学习内容简述" ref="resumes_1" v-model="resumes_1"></el-input>
                          </el-col>
                      </el-row>
                      <el-row>
                          <el-col :span="24">
                            <div class="grid-content">
                              <div class="block">
                                <el-date-picker v-model="resume2" type="daterange" placeholder="选择日期范围" ref="date_section2" :editable="false"></el-date-picker>
                              </div>
                            </div>
                          </el-col>
                      </el-row>
                      <el-row>
                          <el-col :span="24">
                            <el-input type="textarea" placeholder="单位/学校名称、职位/专业、工作/学习内容简述" ref="resumes_2" v-model="resumes_2"></el-input>
                          </el-col>
                      </el-row>
                      <el-row>
                          <el-col :span="24">
                            <div class="grid-content">
                              <div class="block">
                                <el-date-picker v-model="resume3" type="daterange" placeholder="选择日期范围" ref="date_section3" :editable="false"></el-date-picker>
                              </div>
                            </div>
                          </el-col>
                      </el-row>
                      <el-row>
                          <el-col :span="24">
                            <el-input type="textarea" placeholder="单位/学校名称、职位/专业、工作/学习内容简述" ref="resumes_3" v-model="resumes_3"></el-input>
                          </el-col>
                      </el-row>
             </el-form-item>
             <el-form-item label="紧急联系人及电话" prop="urgent_contact" label-width="200px">
             </el-form-item>
          <el-row class="font">
              <el-col :span="24">
                  <div class="grid-content marginleft">
                      <el-form-item label="" prop="urgent_contact">
                          <el-input type="textarea" v-model="ruleForm.urgent_contact" ref="urgent_contact"></el-input>
                      </el-form-item>
                  </div>
              </el-col>
          </el-row>
          <el-form-item label="护理经验" prop="nursing" label-width="200px">
          </el-form-item>
          <el-row class="font">
              <el-col :span="24">
                  <div class="grid-content marginleft">
                      <el-form-item label="" prop="nursing">
                          <el-input type="textarea" v-model="ruleForm.nursing" ref="nursing"></el-input>
                      </el-form-item>
                  </div>
              </el-col>
          </el-row>
          <el-form-item label="报名理由及自己的性格特点" prop="character" label-width="200px">
          </el-form-item>
          <el-row class="font">
              <el-col :span="24">
                  <div class="grid-content marginleft">
                      <el-form-item label="" prop="character">
                          <el-input type="textarea" v-model="ruleForm.character" ref="character"></el-input>
                      </el-form-item>
                  </div>
              </el-col>
          </el-row>
          <el-form-item label="备注" prop="remark" label-width="200px">
          </el-form-item>
          <el-row class="font">
              <el-col :span="24">
                  <div class="grid-content marginleft">
                      <el-form-item label="" prop="remark">
                          <el-input type="textarea" v-model="ruleForm.remark" ref="remark"></el-input>
                      </el-form-item>
                  </div>
              </el-col>
          </el-row>
          <el-form-item class="center">
            <el-button type="primary" @click="submitForm('ruleForm')">立即提交</el-button>
          </el-form-item>
          </el-form>
    </div>
</body>
<script src="<?php echo base_url()?>apply/js/vue.js"></script>
  <script src="<?php echo base_url()?>apply/js/index.js"></script>
  <script src="<?php echo base_url()?>apply/js/jquery-1.11.1.js"></script>
  <script>
      /**
        * Created by Administrator on 2017/7/9.
        */
       Date.prototype.Format = function(format){
           var o = {
               "M+" : this.getMonth()+1, //month
               "d+" : this.getDate(), //day
               "h+" : this.getHours(), //hour
               "m+" : this.getMinutes(), //minute
               "s+" : this.getSeconds(), //second
               "q+" : Math.floor((this.getMonth()+3)/3), //quarter
               "S" : this.getMilliseconds() //millisecond
           }
           if(/(y+)/.test(format)) {
               format = format.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
           }
           for(var k in o) {
               if(new RegExp("("+ k +")").test(format)) {
                   format = format.replace(RegExp.$1, RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length));
               }
           }
           return format;
       }
    var image_name = '';
    new Vue({
        el: '#app',
        data() {
            var checkPhoto = (rule, value, callback) => {
                if (image_name == '') {
                    return callback(new Error('请上传图片'));
                } else {
                    callback();
                }
            };
      return {
        imageUrl: '',
        resume1:'',
        resume2:'',
        resume3:'',
        resumes_1:'',
        resumes_2:'',
        resumes_3:'',
        numberValidateForm: {
          phone: ''
        },
        dynamicValidateForm: {
          domains: [{
            value: ''
          }],
          email: ''
        },
        ruleForm: {
          c_name:'',
          e_name: '',
          radio:'1',
          nation:'',
          id:'',
          date: '',
          phone:'',
          qq:'',
          id_place:'',
          place:'',
          area:'',
          is_married:'',
          is_health:'',
          german_grade:'',
          education:'',
          record:'无',
          urgent_contact: '',
          nursing:'',
          character:'',
          remark: '',
        },
        rules: {
          c_name: [
            { required: true, message: '请输入姓名', trigger: 'blur' }
          ],
          id: [
            { required: true, message: '请输入身份证号码', trigger: 'blur' }
          ],
          qq: [
            { required: true, message: '请输入QQ号码', trigger: 'blur' }
          ],
          photo: [
            { validator: checkPhoto, trigger: 'blur' }
          ],
          urgent_contact: [
            { required: true, message: '请输入紧急联系人及电话', trigger: 'blur' }
          ],
          date: [
           { type: 'date', required: true, message: '请选择日期', trigger: 'change' }
          ],
           phone: [
              { required: true, message: '请输入qq号码', trigger: 'blur'  }
            ],
         }
      };
    },
    mounted(){
        if($(document.body).width()>=800){
            $("body").addClass("padding");
        }else{
            $("body").removeClass("padding");
        }
    },
    methods: {
        handleAvatarSuccess(res, file) {
          this.imageUrl = URL.createObjectURL(file.raw);
          image_name = res;
        },
        beforeAvatarUpload(file) {
          const isJPG = file.type === 'image/jpeg';
          const isLt2M = file.size / 1024 / 1024 < 2;

          if (!isJPG) {
            this.$message.error('上传头像图片只能是 JPG 格式!');
          }
          if (!isLt2M) {
            this.$message.error('上传头像图片大小不能超过 2MB!');
          }
          return isJPG && isLt2M;
      },
      submitForm(formName) {
        this.$refs[formName].validate((valid) => {
            if (valid) {
                var photo_name = image_name;                                    // 图片
                var name = this.$refs.c_name.value;                             // 姓名
                var pinyin = this.$refs.e_name.value;                           // 拼音
                var sex = this.$refs.radio.value;                               // 性别
                var nation = this.$refs.nation.value;                           // 民族
                var id_number = this.$refs.id.value;                            // 身份证号
                var birthday = this.$refs.date.value;                           // 生日
                var phone = this.$refs.phone.value;                             // 电话号码
                var qq = this.$refs.qq.value;                                   // QQ号码
                var email = this.$refs.email.value;                             // 邮件
                var domicile = this.$refs.id_place.value;                       // 户籍所在地
                var address = this.$refs.place.value;                           // 家庭住址
                var region = this.$refs.area.value;                             // 地区
                var number = this.$refs.num.value;                              // 编号
                var marital_status = this.$refs.is_married.value;               // 婚姻状况
                var health = this.$refs.is_health.value;                        // 健康状况
                var german_level = this.$refs.german_grade.value;               // 德语等级
                var degree_of_education = this.$refs.education.value;           // 文化程度
                var criminal_record = this.$refs.record.value;                  // 犯罪记录
                
                var date_section1 = this.$refs.date_section1.value;
                var date_section2 = this.$refs.date_section2.value;
                var date_section3 = this.$refs.date_section3.value;

                if(typeof(date_section1[0]) == "undefined"){ 
                    var date_section_1_1 = '';
                } else {
                    var date_section_1_1 = date_section1[0].Format('yyyy-MM-dd');
                }
                if(typeof(date_section1[1]) == "undefined"){ 
                    var date_section_1_2 = '';
                } else {
                    var date_section_1_2 = date_section1[0].Format('yyyy-MM-dd');
                }
                var resume_1 = this.$refs.resumes_1.value;
                
                if(typeof(date_section2[0]) == "undefined"){ 
                    var date_section_2_1 = '';
                } else {
                    var date_section_2_1 = date_section1[0].Format('yyyy-MM-dd');
                }
                if(typeof(date_section2[1]) == "undefined"){ 
                    var date_section_2_2 = '';
                } else {
                    var date_section_2_2 = date_section1[0].Format('yyyy-MM-dd');
                }
                var resume_2 = this.$refs.resumes_2.value;
                
                if(typeof(date_section3[0]) == "undefined"){ 
                    var date_section_3_1 = '';
                } else {
                    var date_section_3_1 = date_section1[0].Format('yyyy-MM-dd');
                }
                if(typeof(date_section3[1]) == "undefined"){ 
                    var date_section_3_2 = '';
                } else {
                    var date_section_3_2 = date_section1[0].Format('yyyy-MM-dd');
                }
                var resume_3 = this.$refs.resumes_3.value;
                
                var contacts_and_phone = this.$refs.urgent_contact.value;       // 紧急联系人和电话
                var nursing_experience = this.$refs.nursing.value;              // 护理经验
                var reason = this.$refs.character.value;                        // 报名理由及自己的性格特点
                var remarks = this.$refs.remark.value;                          // 备注
                var _self = this;
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>/apply_in/insert_data",
                    data: {"photo_name":photo_name, 
                            "name":name, 
                            "pinyin":pinyin, 
                            "sex":sex, 
                            "nation":nation, 
                            "id_number":id_number, 
                            "birthday": birthday.Format('yyyy-MM-dd'), 
                            "phone":phone, 
                            "qq":qq, 
                            "email":email, 
                            "domicile":domicile, 
                            "address":address, 
                            "region":region, 
                            "number":number, 
                            "marital_status":marital_status, 
                            "health":health, 
                            "german_level":german_level, 
                            "degree_of_education":degree_of_education, 
                            "criminal_record":criminal_record, 
                            "date_section_1_1":date_section_1_1, 
                            "date_section_1_2":date_section_1_2, 
                            "resume_1":resume_1, 
                            "date_section_2_1":date_section_2_1, 
                            "date_section_2_2":date_section_2_2, 
                            "resume_2":resume_2, 
                            "date_section_3_1":date_section_3_1, 
                            "date_section_3_2":date_section_3_2, 
                            "resume_3":resume_3, 
                            "contacts_and_phone":contacts_and_phone, 
                            "nursing_experience":nursing_experience, 
                            "reason":reason, 
                            "remarks":remarks},
                    success: function(result){
                        _self.$message({
                            message: '您已提交成功！',
                            type: 'success'
                        });
                        setTimeout(function() {
                            location.href="<?php echo base_url()?>apply_in"
                        },2000);
                    }
                });
            } else {
              console.log('error submit!!');
              return false;
            }
        });
      }
    }
})
  </script>
</html>
