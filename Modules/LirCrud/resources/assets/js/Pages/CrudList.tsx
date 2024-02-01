
import React, { useEffect, useState } from 'react';
import {useSideBar} from '@/lircrud/Stores/useSideBar'

import { Table, Row, Col, Button, App } from 'antd';
import axios from 'axios'
import {useTranslate} from '@/lircrud/Stores/useTranslate'
import type { ColumnsType } from 'antd/es/table';

import {usePage} from '@inertiajs/react'
interface User {
  id: number,
}
const columns: ColumnsType<User> = [
  {
    title: 'ID',
    dataIndex: 'id',
    sorter: true,
    // render: (name) => `${name.first} ${name.last}`,
    width: '20%',
  },
  {
    title: 'Value',
    dataIndex: 'value',
    filterMode: 'tree',
    filters: [
      {
        text: 'Male',
        value: 'male',
      },
      {
        text: 'Female',
        value: 'female',
      },
    ],
    width: '20%',
  },
  {
    title: 'Active',
    dataIndex: 'active',
  },
];

export default () => {
  const {props} = usePage<{[key: string]: any}>()
  const t = useTranslate(state => state.t)
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(false);
  const [tableParams, setTableParams] = useState({
    pagination: {
      current: 1,
      pageSize: 10,
      total: 1
    },
  });
  const goToPage = useSideBar(state => state.goToPage)
  // const {pageTitle} = usePage().props


  const { notification } = App.useApp();
  const fetchData = () => {
    setLoading(true);
    axios.post(`${baseUrl}/admin/setting/search`, {

    })
      // .then((res) => res.json())
      .then(res => {
        const {data, total, current_page, per_page} = res.data
        setData(data);
        setLoading(false);
        setTableParams({
          ...tableParams,
          pagination: {
            current: current_page,
            pageSize: per_page,
            // ...tableParams.pagination,
            total: total,
            // 200 is mock data, you should read it from server
            // total: data.totalCount,
          },
        });
      })
      .catch(e => {
        notification.error({
          message: `Error`,
          description: e.response.data?.message ?? 'Something when wrong.',
          placement: 'topRight',
        });
      });
  };
  useEffect(() => {
    fetchData();
  }, [JSON.stringify(tableParams)]);
  const handleTableChange = (pagination: any, filters: any, sorter: any) => {
    setTableParams({
      pagination,
      filters,
      ...sorter,
    });

    // `dataSource` is useless since `pageSize` changed
    if (pagination.pageSize !== tableParams.pagination?.pageSize) {
      setData([]);
    }
  };
  
  return (
    <Row>
      <Col>
      {t('lircrud::default.Call me')}
        <code><pre className="max-w-50 whitespace-pre-wrap">{JSON.stringify(props)}</pre></code>
      </Col>
      <Col span={24}>
        <h1>{t(props.pageTitles)}, {t('Callme')}</h1>
      </Col>
      <Col span={24} className={'mb-5'}>
        <Button type="primary" onClick={() => goToPage('/admin/user/create')}>{t('Add')} {t(props.pageTitle)}</Button>
      </Col>
      <Col span={24}>
      <Table
        
        columns={columns}
        rowKey={(record) => record.id}
        dataSource={data}
        pagination={tableParams.pagination}
        loading={loading}
        onChange={handleTableChange}
      />
      </Col>
    </Row>
  )
}